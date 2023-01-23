import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faTwitter } from "@fortawesome/free-brands-svg-icons/faTwitter";
import { faGithub } from "@fortawesome/free-brands-svg-icons/faGithub";
import { Container } from "rrd-ui";

const Footer = () => {
    return (
        <footer className="bg-white py-4">
            <Container className="md:flex md:items-center md:justify-between">
                <div className="flex justify-center space-x-6 md:order-2">
                    <a
                        href="https://twitter.com/RedRDLtd"
                        className="text-gray-400 hover:text-gray-500"
                        target="_blank"
                        rel="noreferrer"
                    >
                        <span className="sr-only">Twitter</span>
                        <FontAwesomeIcon icon={faTwitter} className="h-6 w-6" />
                    </a>

                    <a
                        href="https://github.com/redrockdigital"
                        className="text-gray-400 hover:text-gray-500"
                        target="_blank"
                        rel="noreferrer"
                    >
                        <span className="sr-only">GitHub</span>
                        <FontAwesomeIcon icon={faGithub} className="h-6 w-6" />
                    </a>
                </div>
                <div className="mt-8 md:order-1 md:mt-0">
                    <p className="text-center text-base text-gray-400">
                        &copy; {(new Date()).getFullYear()} Red Rock Digital LTD. All rights reserved.</p>
                </div>
            </Container>
        </footer>
    );
};

export default Footer;
