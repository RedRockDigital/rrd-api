import React from "react";
import PropTypes from "prop-types";
import { Link } from "react-router-dom";

const Unauthenticated = ({ children }) => {
    return (
        <div className="h-screen bg-gray-100 w-full flex flex-col items-center justify-center">
            <Link to="/" className="mb-8">
                <img
                    className="h-8 w-auto"
                    src="https://tailwindui.com/img/logos/workflow-mark-gray-300.svg"
                    alt="Workflow"
                />
            </Link>

            {children}
        </div>
    );
};

Unauthenticated.propTypes = {
    children: PropTypes.oneOfType([
        PropTypes.arrayOf(PropTypes.node),
        PropTypes.node,
    ]).isRequired,
};

export default Unauthenticated;
