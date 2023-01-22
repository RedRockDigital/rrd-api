import React from "react";
import PropTypes from "prop-types";

import Header from "./Header";
import Footer from "./Footer";

import { Cta } from "@/Components/Partials";

const Marketing = ({ children, includeCta = true }) => {
    return (
        <div className="flex flex-col min-h-screen bg-gray-50">
            <Header />

            <div className="flex-1 mt-20">
                {children}
            </div>

            {includeCta && (
                <Cta />
            )}

            <Footer />
        </div>
    );
};

Marketing.propTypes = {
    children: PropTypes.oneOfType([
        PropTypes.arrayOf(PropTypes.node),
        PropTypes.node,
    ]).isRequired,
    includeCta: PropTypes.bool,
};

export default Marketing;
