import React from "react";
import { Link } from "react-router-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faFacebook } from "@fortawesome/free-brands-svg-icons/faFacebook";
import { faTwitter } from "@fortawesome/free-brands-svg-icons/faTwitter";
import { faGithub } from "@fortawesome/free-brands-svg-icons/faGithub";
import { Container, useLanguage } from "rrd-ui";

import Newsletter from "./Newsletter";

const linkClassName = "text-base text-gray-500 hover:text-gray-900";

const productMenu = [
    {
        to: "/pricing",
        label_ref: "footer_menu_pricing",
    },
    {
        to: "/roadmap",
        label_ref: "footer_menu_roadmap",
    },
];

const supportMenu = [
    {
        to: "/docs",
        label_ref: "footer_menu_documentation",
    },
    {
        to: "/blogs?category=guides",
        label_ref: "footer_menu_guides",
    },
    {
        to: "/consultancy",
        label_ref: "footer_menu_consultancy",
    },
    {
        to: "/contact",
        label_ref: "footer_menu_contact",
    },
    {
        to: "/status",
        label_ref: "footer_menu_status",
    },
];

const companyMenu = [
    {
        to: "/blogs",
        label_ref: "footer_menu_blog",
    },
    {
        to: "/careers",
        label_ref: "footer_menu_careers",
    },
    {
        to: import.meta.env.VITE_REWARDFUL_REFERRAL_LINK,
        label_ref: "footer_menu_referrals",
    },
];

const legalMenu = [
    {
        to: "/legal/terms",
        label_ref: "footer_menu_terms",
    },
    {
        to: "/legal/privacy",
        label_ref: "footer_menu_privacy",
    },
    {
        to: "/legal/cookies",
        label_ref: "footer_menu_cookies",
    },
];

const Footer = () => {
    const { c } = useLanguage();
    return (
        <footer className="bg-white border-t border-gray-100" aria-labelledby="footer-heading">
            <h2 id="footer-heading" className="sr-only">Footer</h2>

            <Container className="py-12 lg:py-16">
                <div className="xl:grid xl:grid-cols-3 xl:gap-8">
                    <div className="grid grid-cols-2 gap-8 xl:col-span-2">
                        <div className="md:grid md:grid-cols-2 md:gap-8">
                            <div>
                                <h3 className="text-sm font-semibold text-gray-400 tracking-wider uppercase">{c("footer_header_product")}</h3>
                                <ul className="mt-4 space-y-4">
                                    {productMenu
                                        .filter(item => item.to)
                                        .map((item, key) => (
                                            <li key={`solutions-${key}`}>
                                                {item.to.indexOf("://") !== -1 && (
                                                    <a target="_blank" href={item.to} className={linkClassName} rel="noreferrer">{c(item.label_ref)}</a>
                                                )}

                                                {item.to.indexOf("://") === -1 && (
                                                    <Link to={item.to} className={linkClassName}>{c(item.label_ref)}</Link>
                                                )}
                                            </li>
                                        ))}
                                </ul>
                            </div>
                            <div className="mt-12 md:mt-0">
                                <h3 className="text-sm font-semibold text-gray-400 tracking-wider uppercase">{c("footer_header_support")}</h3>
                                <ul className="mt-4 space-y-4">
                                    {supportMenu
                                        .filter(item => item.to)
                                        .map((item, key) => (
                                            <li key={`solutions-${key}`}>
                                                {item.to.indexOf("://") !== -1 && (
                                                    <a target="_blank" href={item.to} className={linkClassName} rel="noreferrer">{c(item.label_ref)}</a>
                                                )}

                                                {item.to.indexOf("://") === -1 && (
                                                    <Link to={item.to} className={linkClassName}>{c(item.label_ref)}</Link>
                                                )}
                                            </li>
                                        ))}
                                </ul>
                            </div>
                        </div>
                        <div className="md:grid md:grid-cols-2 md:gap-8">
                            <div>
                                <h3 className="text-sm font-semibold text-gray-400 tracking-wider uppercase">{c("footer_header_company")}</h3>
                                <ul className="mt-4 space-y-4">
                                    {companyMenu
                                        .filter(item => item.to)
                                        .map((item, key) => (
                                            <li key={`solutions-${key}`}>
                                                {item.to.indexOf("://") !== -1 && (
                                                    <a target="_blank" href={item.to} className={linkClassName} rel="noreferrer">{c(item.label_ref)}</a>
                                                )}

                                                {item.to.indexOf("://") === -1 && (
                                                    <Link to={item.to} className={linkClassName}>{c(item.label_ref)}</Link>
                                                )}
                                            </li>
                                        ))}
                                </ul>
                            </div>
                            <div className="mt-12 md:mt-0">
                                <h3 className="text-sm font-semibold text-gray-400 tracking-wider uppercase">{c("footer_header_legal")}</h3>
                                <ul className="mt-4 space-y-4">
                                    {legalMenu
                                        .filter(item => item.to)
                                        .map((item, key) => (
                                            <li key={`solutions-${key}`}>
                                                {item.to.indexOf("://") !== -1 && (
                                                    <a target="_blank" href={item.to} className={linkClassName} rel="noreferrer">{c(item.label_ref)}</a>
                                                )}

                                                {item.to.indexOf("://") === -1 && (
                                                    <Link to={item.to} className={linkClassName}>{c(item.label_ref)}</Link>
                                                )}
                                            </li>
                                        ))}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div className="mt-8 xl:mt-0">
                        <h3 className="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                            {c("newsletter_header")}
                        </h3>

                        <p className="mt-4 text-base text-gray-500">
                            {c("newsletter_intro")}
                        </p>

                        <Newsletter />
                    </div>
                </div>
                <div className="mt-8 border-t border-gray-200 pt-8 md:flex md:items-center md:justify-between">
                    <div className="flex space-x-6 md:order-2">
                        <a href="https://facebook.com" rel="noreferrer" target="_blank" className="text-gray-400 hover:text-gray-500">
                            <span className="sr-only">{c("facebook")}</span>
                            <FontAwesomeIcon icon={faFacebook} />
                        </a>

                        <a href="https://twitter.com" rel="noreferrer" target="_blank" className="text-gray-400 hover:text-gray-500">
                            <span className="sr-only">{c("twitter")}</span>
                            <FontAwesomeIcon icon={faTwitter} />
                        </a>

                        <a href="https://github.com" rel="noreferrer" target="_blank" className="text-gray-400 hover:text-gray-500">
                            <span className="sr-only">{c("github")}</span>
                            <FontAwesomeIcon icon={faGithub} />
                        </a>
                    </div>
                    <p className="mt-8 text-base text-gray-400 md:mt-0 md:order-1">
                        &copy; {(new Date()).getFullYear()} {c("copyright")}
                    </p>
                </div>
            </Container>
        </footer>
    );
};

export default Footer;
