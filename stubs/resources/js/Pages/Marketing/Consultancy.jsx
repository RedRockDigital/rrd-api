import React from "react";
import { Link } from "react-router-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faLifeRing } from "@fortawesome/free-solid-svg-icons/faLifeRing";
import { faPoundSign } from "@fortawesome/free-solid-svg-icons/faPoundSign";
import { Container, useLanguage } from "rrd-ui";

import MarketingLayout from "@/Components/Layouts/Marketing";
import { Hero } from "@/Components/Partials";

const Consultancy = () => {
    const { c } = useLanguage();

    return (
        <MarketingLayout>
            <Hero>
                <div className="text-center">
                    <h1 className="text-4xl tracking-tight font-extrabold text-gray-800 sm:text-5xl md:text-6xl">
                        {c("consultancy_title")}
                    </h1>
                    <p className="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        {c("consultancy_description")}
                    </p>
                </div>
            </Hero>

            <div className="bg-white">
                <div className="relative bg-gray-800 pb-32">
                    <div className="absolute inset-0">
                        <img
                            className="h-full w-full object-cover"
                            src="https://images.unsplash.com/photo-1525130413817-d45c1d127c42?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1920&q=60&&sat=-100"
                            alt=""
                        />
                        <div className="absolute inset-0 bg-gray-800 mix-blend-multiply" aria-hidden="true"/>
                    </div>

                    <Container className="relative py-24 sm:py-32">
                        <h1 className="text-4xl font-bold tracking-tight text-white md:text-5xl lg:text-6xl">
                            {c("consultancy_custom_development_title")}
                        </h1>
                        <p className="mt-6 max-w-3xl text-xl text-gray-300">
                            {c("consultancy_custom_development_description")}
                        </p>
                    </Container>
                </div>

                <Container
                    className="relative z-10 -mt-32 pb-32"
                >
                    <div className="grid grid-cols-1 gap-y-20 lg:grid-cols-2 lg:gap-y-0 lg:gap-x-8">
                        <div className="flex flex-col rounded-2xl bg-white shadow-xl">
                            <div className="relative flex-1 px-6 pt-16 pb-8 md:px-8">
                                <div
                                    className="absolute top-0 inline-block -translate-y-1/2 transform rounded-xl bg-indigo-600 p-5 shadow-lg">
                                    <FontAwesomeIcon icon={faPoundSign} className="h-6 w-6 text-white"/>
                                </div>
                                <h3 className="text-xl font-medium text-gray-900">
                                    {c("consultancy_price_header")}
                                </h3>
                                <p className="mt-4 text-base text-gray-500">
                                    {c("consultancy_price_description")}
                                </p>
                            </div>
                            <div className="rounded-bl-2xl rounded-br-2xl bg-gray-50 p-6 md:px-8">
                                <Link to="/contact"
                                    className="text-base font-medium text-indigo-700 hover:text-indigo-600">
                                    {c("consultancy_contact_us")}<span aria-hidden="true"> &rarr;</span>
                                </Link>
                            </div>
                        </div>

                        <div className="flex flex-col rounded-2xl bg-white shadow-xl">
                            <div className="relative flex-1 px-6 pt-16 pb-8 md:px-8">
                                <div
                                    className="absolute top-0 inline-block -translate-y-1/2 transform rounded-xl bg-indigo-600 p-5 shadow-lg">
                                    <FontAwesomeIcon icon={faLifeRing} className="h-6 w-6 text-white"/>
                                </div>
                                <h3 className="text-xl font-medium text-gray-900">
                                    {c("consultancy_support_header")}
                                </h3>
                                <p className="mt-4 text-base text-gray-500">
                                    {c("consultancy_support_description")}
                                </p>
                            </div>
                            <div className="rounded-bl-2xl rounded-br-2xl bg-gray-50 p-6 md:px-8">
                                <Link to="/contact"
                                    className="text-base font-medium text-indigo-700 hover:text-indigo-600">
                                    {c("consultancy_contact_us")}<span aria-hidden="true"> &rarr;</span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </Container>
            </div>

        </MarketingLayout>
    );
};

export default Consultancy;
