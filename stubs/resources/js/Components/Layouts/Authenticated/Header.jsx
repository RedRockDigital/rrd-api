import React, { useState, useEffect, useRef } from "react";
import { NavLink, Link } from "react-router-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faBars } from "@fortawesome/free-solid-svg-icons/faBars";
import { faCheckCircle } from "@fortawesome/free-solid-svg-icons/faCheckCircle";
import { faCaretDown } from "@fortawesome/free-solid-svg-icons/faCaretDown";
import { Notifications, Container, HasAccess, useUser, useTeamSwitcher, useLanguage } from "rrd-ui";

import { ProductNews } from "@/Components/Partials";

const navLinks = [
    {
        name_ref: "nav_dashboard",
        href: "/dashboard",
    },
];

const Header = () => {
    const { c } = useLanguage();
    const { user } = useUser();
    const menuRef = useRef();
    const menuTriggerRef = useRef();
    const switchTeam = useTeamSwitcher();

    const [showUserMenu, setShowUserMenu] = useState(false);
    const [showMobileMenu, setShowMobileMenu] = useState(false);

    useEffect(() => {
        window.addEventListener("mousedown", handleDismissUserMenu);
        window.addEventListener("touchstart", handleDismissUserMenu);

        return () => {
            window.removeEventListener("touchstart", handleDismissUserMenu);
        };
    }, []);

    const handleDismissUserMenu = (event) => {
        if (
            !menuRef?.current || menuRef.current.contains(event.target) ||
            menuTriggerRef.current.contains(event.target)
        ) {
            return;
        }

        setShowUserMenu(false);
    };

    const handleSwitchTeam = async (id) => {
        await switchTeam(id);
        setShowUserMenu(false);
    };

    return (
        <nav className="flex-shrink-0 bg-gray-800">
            <Container>
                <div className="relative flex items-center justify-between h-16">
                    <div className="flex items-center px-2 lg:px-0 xl:w-20">
                        <div className="flex-shrink-0">
                            <Link to="/">
                                <img
                                    className="h-8 w-auto"
                                    src="https://tailwindui.com/img/logos/workflow-mark-gray-300.svg"
                                    alt="Workflow"
                                />
                            </Link>
                        </div>
                    </div>

                    <div className="flex-1 space-x-1 hidden md:flex">
                        {navLinks.map(nav => (
                            <NavLink
                                key={nav.name_ref}
                                to={nav.href}
                                className={({ isActive }) => `px-3 py-2 rounded-md text-sm font-medium text-gray-200 ${isActive ? "text-white bg-gray-900" : " hover:text-white transition duration-200 hover:bg-gray-900"}`}
                                aria-current="page"
                            >
                                {c(nav.name_ref)}
                            </NavLink>
                        ))}
                    </div>

                    <div className="flex lg:hidden">
                        <button
                            onClick={() => setShowMobileMenu(!showMobileMenu)}
                            type="button"
                            className="bg-gray-900 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-600 focus:ring-white"
                            aria-controls="mobile-menu"
                            aria-expanded="false"
                        >
                            <span className="sr-only">Open main menu</span>

                            <FontAwesomeIcon icon={faBars} />
                        </button>
                    </div>

                    <div className="hidden lg:block lg:w-80">
                        <div className="flex items-center justify-end">
                            <div className="flex">
                                <ProductNews />

                                <Notifications />
                            </div>

                            <div className="ml-4 relative flex-shrink-0">
                                <div>
                                    <button
                                        ref={menuTriggerRef}
                                        onClick={() => setShowUserMenu(!showUserMenu)}
                                        type="button"
                                        className="flex items-center space-x-2 text-sm rounded-full text-white"
                                        id="user-menu-button"
                                        aria-expanded="false"
                                        aria-haspopup="true"
                                    >
                                        <span>{user?.full_name}</span>
                                        <FontAwesomeIcon icon={faCaretDown} />
                                    </button>
                                </div>

                                {showUserMenu && (
                                    <div
                                        ref={menuRef}
                                        className="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        role="menu"
                                        aria-orientation="vertical"
                                        aria-labelledby="user-menu-button"
                                        tabIndex="-1"
                                    >
                                        <div className="block px-4 py-2 text-xs text-gray-400">Manage Account</div>

                                        <Link
                                            to="/settings/profile"
                                            className="block px-4 py-2 text-sm text-gray-700"
                                            role="menuitem"
                                            tabIndex="-1"
                                        >
                                            Your Profile
                                        </Link>

                                        <HasAccess scope="team.manage">
                                            <>
                                                <div className="border-t border-gray-100" />
                                                <div className="block px-4 py-2 text-xs text-gray-400">Manage Team</div>

                                                <Link
                                                    to="/team/settings"
                                                    className="block px-4 py-2 text-sm text-gray-700"
                                                    role="menuitem"
                                                    tabIndex="-1"
                                                >
                                                    Team Settings
                                                </Link>
                                            </>
                                        </HasAccess>

                                        <div className="border-t border-gray-100" />
                                        <div className="block px-4 py-2 text-xs text-gray-400">Switch Team</div>

                                        {user?.teams?.map(team => (
                                            <div
                                                key={team.id}
                                                className="block px-4 py-2 text-sm text-gray-700 cursor-pointer"
                                                role="menuitem"
                                                tabIndex="-1"
                                                onClick={() => handleSwitchTeam(team.id)}
                                            >
                                                {user?.current_team_id === team.id && (
                                                    <FontAwesomeIcon icon={faCheckCircle} className="mr-1 text-green-400" />
                                                )}
                                                {team.name}
                                            </div>
                                        ))}

                                        <div className="border-t border-gray-100" />

                                        <Link
                                            to="/team/create"
                                            className="block px-4 py-2 text-sm text-gray-700"
                                            role="menuitem"
                                            tabIndex="-1"
                                        >
                                            Create New Team
                                        </Link>

                                        <div className="border-t border-gray-100" />

                                        <Link
                                            to="/logout"
                                            className="block px-4 py-2 text-sm text-gray-700"
                                            role="menuitem"
                                            tabIndex="-1"
                                        >
                                            Sign out
                                        </Link>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </Container>

            {showMobileMenu && (
                <div className="lg:hidden" id="mobile-menu">
                    <div className="px-2 pt-2 pb-3 space-y-1">
                        {navLinks.map(nav => (
                            <NavLink
                                key={nav.name_ref}
                                to={nav.href}
                                className={({ isActive }) => `px-3 py-2 rounded-md text-sm font-medium text-gray-200 block w-full ${isActive ? "text-white bg-gray-900" : "hover:text-white transition duration-200 hover:bg-gray-900"}`}
                                aria-current="page"
                            >
                                {c(nav.name_ref)}
                            </NavLink>
                        ))}
                    </div>
                    <div className="pt-4 pb-3 border-t border-gray-800">
                        <div className="space-y-1">
                            <div className="block px-3 py-1 text-md text-gray-400">Manage Account</div>
                            <Link
                                to="/profile/settings"
                                className="block px-5 py-1 rounded-md text-xs font-medium text-gray-200 hover:text-gray-100 hover:bg-gray-600"
                            >
                                Your Profile
                            </Link>

                            <div className="border-t border-gray-800" />

                            <div className="block px-3 py-1 text-md text-gray-400">Manage Team</div>

                            <Link
                                to="/team/settings"
                                className="block px-5 py-1 rounded-md text-xs font-medium text-gray-200 hover:text-gray-100 hover:bg-gray-600"
                                role="menuitem"
                                tabIndex="-1"
                            >
                                Team Settings
                            </Link>

                            <div className="border-t border-gray-800" />
                            <div className="block px-3 py-1 text-md text-gray-400">Switch Team</div>

                            {user?.teams?.map(team => (
                                <div
                                    key={team.id}
                                    className="block px-5 py-1 rounded-md text-xs font-medium text-gray-200 hover:text-gray-100 hover:bg-gray-600"
                                    role="menuitem"
                                    tabIndex="-1"
                                    onClick={() => switchTeam(team.id)}
                                >
                                    {user?.current_team_id === team.id && (
                                        <FontAwesomeIcon icon={faCheckCircle} className="mr-1 text-green-400" />
                                    )}
                                    {team.name}
                                </div>
                            ))}

                            <div className="border-t border-gray-800" />

                            <Link
                                to="/team/create"
                                className="block px-5 py-1 rounded-md text-xs font-medium text-gray-200 hover:text-gray-100 hover:bg-gray-600"
                                role="menuitem"
                                tabIndex="-1"
                            >
                                Create New Team
                            </Link>

                            <div className="border-t border-gray-800" />

                            <Link
                                to="/logout"
                                className="block px-5 py-1 rounded-md text-xs font-medium text-gray-200 hover:text-gray-100 hover:bg-gray-600"
                                role="menuitem"
                                tabIndex="-1"
                            >
                                Sign out
                            </Link>
                        </div>
                    </div>
                </div>
            )}
        </nav>
    );
};

export default Header;
