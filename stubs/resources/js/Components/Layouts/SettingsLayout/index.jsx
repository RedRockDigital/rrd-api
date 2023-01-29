import React from "react";
import PropTypes from "prop-types";
import { AsideNav, Container, useLanguage } from "rrd-ui";
import { faUser } from "@fortawesome/free-solid-svg-icons/faUser";
import { faLock } from "@fortawesome/free-solid-svg-icons/faLock";
import { faMobile } from "@fortawesome/free-solid-svg-icons/faMobile";
import { faBell } from "@fortawesome/free-solid-svg-icons/faBell";
import { faKey } from "@fortawesome/free-solid-svg-icons/faKey";

import { PageHeader } from "@/Components/Partials";

import Authenticated from "@/Components/Layouts/Authenticated";

const subNavigation = [
    { name_ref: "settings_profile_details", href: "/settings/profile", icon: faUser },
    { name_ref: "settings_profile_password", href: "/settings/password", icon: faLock },
    { name_ref: "settings_profile_two_factor", href: "/settings/two-factor", icon: faMobile },
    { name_ref: "settings_profile_api_keys", href: "/settings/api-keys", icon: faKey },
    { name_ref: "settings_profile_notifications", href: "/settings/notifications", icon: faBell },
];

const SettingsLayout = ({ children, pageTitle }) => {
    const { c } = useLanguage();

    return (
        <Authenticated>
            <PageHeader>
                {pageTitle ?? c("settings_page_title")}
            </PageHeader>

            <Container className="pb-10 lg:py-12">
                <div className="lg:grid lg:grid-cols-12 lg:gap-x-5">
                    <AsideNav
                        nav={subNavigation}
                    />

                    <div className="sm:px-6 lg:col-span-9 lg:px-0">
                        {children}
                    </div>
                </div>
            </Container>
        </Authenticated>
    );
};

SettingsLayout.propTypes = {
    children: PropTypes.element.isRequired,
    pageTitle: PropTypes.string,
};

export default SettingsLayout;
