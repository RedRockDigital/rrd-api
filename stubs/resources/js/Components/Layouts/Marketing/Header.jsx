import React, { useState } from "react";
import { Link } from "react-router-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTimes } from "@fortawesome/free-solid-svg-icons/faTimes";
import { faBars } from "@fortawesome/free-solid-svg-icons/faBars";
import { PrimaryButton, SecondaryButton, Container, useLanguage } from "rrd-ui";

const links = [
    {
        to: "/",
        label_ref: "nav_welcome",
    },
    {
        to: "/blogs",
        label_ref: "nav_blog",
    },
];

const Header = () => {
    const { c } = useLanguage();
    const [mobileMenuVisible, setMobileMenuVisible] = useState(false);

    return (
        <div className="fixed top-0 inset-x-0 z-20 flex items-center bg-white h-20 shadow-sm">
            <Container>
                <nav className="relative flex items-center justify-between sm:h-10 md:justify-center"
                    aria-label="Global">
                    <div className="flex items-center flex-1 md:absolute md:inset-y-0 md:left-0">
                        <div className="flex items-center justify-between w-full md:w-auto">
                            <Link to="/">
                                <span className="sr-only">{c("redrock")}</span>
                                <img
                                    className="h-8 w-auto sm:h-10"
                                    src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                                    alt=""
                                />
                            </Link>
                            <div className="-mr-2 flex items-center md:hidden">
                                <button
                                    type="button"
                                    className="bg-gray-50 rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                                    aria-expanded="false"
                                    onClick={() => setMobileMenuVisible(true)}
                                >
                                    <FontAwesomeIcon icon={faBars} />
                                </button>
                            </div>
                        </div>
                    </div>
                    <div className="hidden md:flex md:space-x-10">
                        {links.map((link, key) => (
                            <Link
                                key={`desktop-${key}`}
                                to={link.to}
                                className="font-medium text-gray-500 hover:text-gray-900"
                            >
                                {c(link.label_ref)}
                            </Link>
                        ))}
                    </div>
                    <div className="hidden md:absolute md:flex md:items-center md:justify-end md:inset-y-0 md:right-0 space-x-2">
                        <Link
                            to="/login"
                        >
                            <SecondaryButton className="shadow">
                                {c("sign_in")}
                            </SecondaryButton>
                        </Link>

                        <Link
                            to="/register"
                        >
                            <PrimaryButton className="shadow">
                                {c("sign_up")}
                            </PrimaryButton>
                        </Link>
                    </div>
                </nav>
            </Container>

            {mobileMenuVisible && (
                <div className="absolute z-10 top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
                    <div className="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5 overflow-hidden">
                        <div className="px-5 pt-4 flex items-center justify-between">
                            <div>
                                <img className="h-8 w-auto"
                                    src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt=""/>
                            </div>
                            <div className="-mr-2">
                                <button
                                    onClick={() => setMobileMenuVisible(false)}
                                    type="button"
                                    className="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                                >
                                    <FontAwesomeIcon icon={faTimes} />
                                </button>
                            </div>
                        </div>
                        <div className="px-2 pt-2 pb-3">
                            {links.map((link, key) => (
                                <Link
                                    key={`mobile-${key}`}
                                    to={link.to}
                                    className="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50"
                                >
                                    {c(link.label_ref)}
                                </Link>
                            ))}
                        </div>
                        <Link
                            to="/login"
                            className="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100"
                        >
                            {c("sign_in")}
                        </Link>
                    </div>
                </div>
            )}
        </div>
    );
};

export default Header;
