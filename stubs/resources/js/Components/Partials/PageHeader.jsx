import React from "react";
import PropTypes from "prop-types";
import { Container } from "rrd-ui";

const PageHeader = ({ children }) => {
    return (
        <header className="bg-white shadow-sm">
            <Container className="py-4">
                <h1 className="text-lg font-semibold leading-6 text-gray-900">
                    {children}
                </h1>
            </Container>
        </header>
    );
};

PageHeader.propTypes = {
    children: PropTypes.oneOfType([
        PropTypes.arrayOf(PropTypes.node),
        PropTypes.node,
    ]).isRequired,
};

export default PageHeader;
