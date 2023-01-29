import React, { useState } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faEnvelope } from "@fortawesome/free-solid-svg-icons/faEnvelope";
import { faTwitter } from "@fortawesome/free-brands-svg-icons/faTwitter";
import { faGithub } from "@fortawesome/free-brands-svg-icons/faGithub";
import { faCheck } from "@fortawesome/free-solid-svg-icons/faCheck";
import { Alert, Container, Input, Textarea, PrimaryButton, useLanguage, useRequest, useForm } from "rrd-ui";

import MarketingLayout from "@/Components/Layouts/Marketing";
import { Hero } from "@/Components/Partials";

const Contact = () => {
    const [success, setSuccess] = useState(false);

    const { c } = useLanguage();
    const { working, alert, value, handleInput, handleSubmit } = useForm();
    const { post } = useRequest();

    const handleRequest = (form) => post("contact", form);

    const handleSuccess = () => setSuccess(true);

    return (
        <MarketingLayout>
            <Hero>
                <div className="text-center">
                    <h1 className="text-4xl tracking-tight font-extrabold text-gray-800 sm:text-5xl md:text-6xl">
                        {c("contact_title")}
                    </h1>
                    <p className="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        {c("contact_description")}
                    </p>
                </div>
            </Hero>

            <Container className="py-24">
                <div className="relative bg-white shadow-xl rounded-lg">
                    <h2 id="contact-heading" className="sr-only">Contact us</h2>

                    <div className="grid grid-cols-1 lg:grid-cols-3">
                        <div
                            className="relative overflow-hidden bg-gradient-to-b from-indigo-500 to-indigo-600 py-10 px-6 sm:px-10 xl:p-12">
                            <div className="pointer-events-none absolute inset-0 sm:hidden" aria-hidden="true">
                                <svg
                                    className="absolute inset-0 h-full w-full"
                                    width="343"
                                    height="388"
                                    viewBox="0 0 343 388"
                                    fill="none"
                                    preserveAspectRatio="xMidYMid slice"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M-99 461.107L608.107-246l707.103 707.107-707.103 707.103L-99 461.107z"
                                        fill="url(#linear1)"
                                        fillOpacity=".1"
                                    />
                                    <defs>
                                        <linearGradient
                                            id="linear1"
                                            x1="254.553"
                                            y1="107.554"
                                            x2="961.66"
                                            y2="814.66"
                                            gradientUnits="userSpaceOnUse"
                                        >
                                            <stop stopColor="#fff" />
                                            <stop offset="1" stopColor="#fff" stopOpacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <div
                                className="pointer-events-none absolute top-0 right-0 bottom-0 hidden w-1/2 sm:block lg:hidden"
                                aria-hidden="true"
                            >
                                <svg
                                    className="absolute inset-0 h-full w-full"
                                    width="359"
                                    height="339"
                                    viewBox="0 0 359 339"
                                    fill="none"
                                    preserveAspectRatio="xMidYMid slice"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M-161 382.107L546.107-325l707.103 707.107-707.103 707.103L-161 382.107z"
                                        fill="url(#linear2)"
                                        fillOpacity=".1"
                                    />
                                    <defs>
                                        <linearGradient
                                            id="linear2"
                                            x1="192.553"
                                            y1="28.553"
                                            x2="899.66"
                                            y2="735.66"
                                            gradientUnits="userSpaceOnUse"
                                        >
                                            <stop stopColor="#fff" />
                                            <stop offset="1" stopColor="#fff" stopOpacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <div
                                className="pointer-events-none absolute top-0 right-0 bottom-0 hidden w-1/2 lg:block"
                                aria-hidden="true"
                            >
                                <svg
                                    className="absolute inset-0 h-full w-full"
                                    width="160"
                                    height="678"
                                    viewBox="0 0 160 678"
                                    fill="none"
                                    preserveAspectRatio="xMidYMid slice"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M-161 679.107L546.107-28l707.103 707.107-707.103 707.103L-161 679.107z"
                                        fill="url(#linear3)"
                                        fillOpacity=".1"
                                    />

                                    <defs>
                                        <linearGradient
                                            id="linear3"
                                            x1="192.553"
                                            y1="325.553"
                                            x2="899.66"
                                            y2="1032.66"
                                            gradientUnits="userSpaceOnUse"
                                        >
                                            <stop stopColor="#fff" />
                                            <stop offset="1" stopColor="#fff" stopOpacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>

                            <h3 className="text-lg font-medium text-white">
                                {c("contact_information")}
                            </h3>
                            <dl className="mt-8 space-y-6">
                                <dt><span className="sr-only">Email</span></dt>
                                <dd className="flex text-base text-teal-50">
                                    <FontAwesomeIcon icon={faEnvelope} className="h-6 w-6 flex-shrink-0 text-teal-200"/>
                                    <span className="ml-3">{import.meta.env.VITE_BASE_SUPPORT_EMAIL}</span>
                                </dd>
                            </dl>
                            <ul role="list" className="mt-8 flex space-x-12">
                                <li>
                                    <a
                                        className="text-teal-200 hover:text-teal-100"
                                        href="https://github.com/redrockdigital"
                                    >
                                        <span className="sr-only">GitHub</span>
                                        <FontAwesomeIcon icon={faGithub} />
                                    </a>
                                </li>
                                <li>
                                    <a className="text-teal-200 hover:text-teal-100" href="#">
                                        <span className="sr-only">Twitter</span>
                                        <FontAwesomeIcon icon={faTwitter} />
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div className="py-10 px-6 sm:px-10 lg:col-span-2 xl:p-12">
                            {success && (
                                <div className="flex justify-center items-center flex-col">
                                    <div className="h-12 w-12 flex items-center justify-center rounded-full bg-green-100">
                                        <FontAwesomeIcon icon={faCheck} />
                                    </div>

                                    <h3 className="mt-3 text-lg font-medium leading-6 text-gray-900">
                                        {c("contact_success_title")}
                                    </h3>

                                    <p className="mt-2 text-sm text-gray-500 text-center">
                                        {c("contact_success_message")}
                                    </p>
                                </div>
                            )}

                            {!success && (
                                <>
                                    <h3 className="text-lg font-medium text-warm-gray-900 mb-6">
                                        {c("contact_send_message")}
                                    </h3>

                                    <form className="space-y-4" onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}>
                                        {alert && (<Alert {...alert} />)}

                                        <Input
                                            name="name"
                                            label={c("contact_name")}
                                            value={value("name")}
                                            onChange={handleInput}
                                        />

                                        <Input
                                            name="email"
                                            type="email"
                                            label={c("contact_email")}
                                            value={value("email")}
                                            onChange={handleInput}
                                        />

                                        <Textarea
                                            name="body"
                                            label={c("contact_message")}
                                            value={value("body")}
                                            onChange={handleInput}
                                        />

                                        <div className="flex justify-end">
                                            <PrimaryButton working={working}>
                                                {c("contact_submit")}
                                            </PrimaryButton>
                                        </div>
                                    </form>
                                </>
                            )}
                        </div>
                    </div>
                </div>
            </Container>
        </MarketingLayout>
    );
};

export default Contact;
