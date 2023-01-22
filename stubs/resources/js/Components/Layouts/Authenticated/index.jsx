import React from "react";
import PropTypes from "prop-types";

import { BillingAlert } from "@/Components/Partials";

import Header from "./Header";
import Footer from "./Footer";

const Authenticated = ({ children }) => {
    return (
        <div className="flex flex-col min-h-screen">
            <BillingAlert />
            <Header />

            <div className="flex-1 bg-gray-100">
                {children}
            </div>

            <Footer />
        </div>
    );
};

Authenticated.propTypes = {
    children: PropTypes.oneOfType([
        PropTypes.arrayOf(PropTypes.node),
        PropTypes.node,
    ]).isRequired,
};

export default Authenticated;
