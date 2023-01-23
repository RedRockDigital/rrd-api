import React from "react";
import PropTypes from "prop-types";
import { faUsers } from "@fortawesome/free-solid-svg-icons/faUsers";
import { faCreditCard } from "@fortawesome/free-solid-svg-icons/faCreditCard";
import { faCog } from "@fortawesome/free-solid-svg-icons/faCog";
import { AsideNav, Container, useLanguage } from "rrd-ui";

import { PageHeader } from "@/Components/Partials";

import Authenticated from "@/Components/Layouts/Authenticated";

const subNavigation = [
    { name_ref: "teams_settings", href: "/team/settings", icon: faCog },
    { name_ref: "teams_users", href: "/team/users", icon: faUsers },
    { name_ref: "teams_billing", href: "/team/billing", icon: faCreditCard, scope: "team.manage-billing" },
];

const TeamsLayout = ({ children, className, pageTitle }) => {
    const { c } = useLanguage();

    return (
        <Authenticated>
            <PageHeader>
                {pageTitle ?? c("teams_page_title")}
            </PageHeader>

            <Container className="pb-10 lg:py-12">
                <div className="lg:grid lg:grid-cols-12 lg:gap-x-5">
                    <AsideNav nav={subNavigation} />

                    <div className={`sm:px-6 lg:col-span-9 lg:px-0 ${className}`}>
                        {children}
                    </div>
                </div>
            </Container>
        </Authenticated>
    );
};

TeamsLayout.propTypes = {
    children: PropTypes.oneOfType([
        PropTypes.arrayOf(PropTypes.node),
        PropTypes.node,
    ]).isRequired,
    className: PropTypes.string,
    pageTitle: PropTypes.string,
};

export default TeamsLayout;
