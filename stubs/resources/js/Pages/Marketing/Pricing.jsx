import React, { useState } from "react";
import PropTypes from "prop-types";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCheck } from "@fortawesome/free-solid-svg-icons/faCheck";
import { Link } from "react-router-dom";
import { Container, useLanguage } from "rrd-ui";

import MarketingLayout from "@/Components/Layouts/Marketing";
import { Hero } from "@/Components/Partials";

const plans = [
    {
        title: "plan_hobby_title",
        description: "plan_hobby_description",
        priceMonth: 12,
        priceYear: 120,
        features: [
            "plan_hobby_feature_1",
            "plan_hobby_feature_2",
            "plan_hobby_feature_3",
        ],
    },
    {
        title: "plan_hobby_title",
        description: "plan_hobby_description",
        priceMonth: 12,
        priceYear: 120,
        features: [
            "plan_hobby_feature_1",
            "plan_hobby_feature_2",
            "plan_hobby_feature_3",
        ],
    },
    {
        title: "plan_hobby_title",
        description: "plan_hobby_description",
        priceMonth: 12,
        priceYear: 120,
        features: [
            "plan_hobby_feature_1",
            "plan_hobby_feature_2",
            "plan_hobby_feature_3",
        ],
    },
    {
        title: "plan_hobby_title",
        description: "plan_hobby_description",
        priceMonth: 12,
        priceYear: 120,
        features: [
            "plan_hobby_feature_1",
            "plan_hobby_feature_2",
            "plan_hobby_feature_3",
        ],
    },
];

const features = [
    {
        title: "pricing_feature_1_title",
        description: "pricing_feature_1_description",
    },
    {
        title: "pricing_feature_1_title",
        description: "pricing_feature_1_description",
    },
    {
        title: "pricing_feature_1_title",
        description: "pricing_feature_1_description",
    },
    {
        title: "pricing_feature_1_title",
        description: "pricing_feature_1_description",
    },
    {
        title: "pricing_feature_1_title",
        description: "pricing_feature_1_description",
    },
    {
        title: "pricing_feature_1_title",
        description: "pricing_feature_1_description",
    },
    {
        title: "pricing_feature_1_title",
        description: "pricing_feature_1_description",
    },
    {
        title: "pricing_feature_1_title",
        description: "pricing_feature_1_description",
    },
    {
        title: "pricing_feature_1_title",
        description: "pricing_feature_1_description",
    },
    {
        title: "pricing_feature_1_title",
        description: "pricing_feature_1_description",
    },
    {
        title: "pricing_feature_1_title",
        description: "pricing_feature_1_description",
    },
    {
        title: "pricing_feature_1_title",
        description: "pricing_feature_1_description",
    },
];

const clients = [
    {
        src: "https://tailwindui.com/img/logos/tuple-logo-purple-200.svg",
        alt: "Company Name",
    },
    {
        src: "https://tailwindui.com/img/logos/tuple-logo-purple-200.svg",
        alt: "Company Name",
    },
    {
        src: "https://tailwindui.com/img/logos/tuple-logo-purple-200.svg",
        alt: "Company Name",
    },
    {
        src: "https://tailwindui.com/img/logos/tuple-logo-purple-200.svg",
        alt: "Company Name",
    },
    {
        src: "https://tailwindui.com/img/logos/tuple-logo-purple-200.svg",
        alt: "Company Name",
    },
];

const faqs = [
    {
        question: "pricing_faqs_question_1",
        answer: "pricing_faqs_answer_1",
    },
    {
        question: "pricing_faqs_question_1",
        answer: "pricing_faqs_answer_1",
    },
    {
        question: "pricing_faqs_question_1",
        answer: "pricing_faqs_answer_1",
    },
];

const Pricing = () => {
    const [period, setPeriod] = useState("yearly");
    const { c } = useLanguage();

    return (
        <MarketingLayout>
            <Hero>
                <div className="text-center">
                    <h1 className="text-4xl tracking-tight font-extrabold text-gray-800 sm:text-5xl md:text-6xl">
                        {c("pricing_title")}
                    </h1>
                    <p className="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        {c("pricing_description")}
                    </p>
                </div>
            </Hero>

            <Container>
                <div className="flex justify-center">
                    <div className="relative mt-6 flex self-center rounded-lg bg-gray-100 p-0.5 sm:mt-8 space-x-0.5">
                        <button
                            onClick={() => setPeriod("monthly")}
                            type="button"
                            className={`
                                relative w-1/2 whitespace-nowrap rounded-md py-2 text-sm font-medium text-gray-900
                                focus:z-10 focus:outline-none focus:ring-2 focus:ring-purple-500 sm:w-auto sm:px-8
                                ${period === "monthly" ? "border-gray-200 bg-white shadow-sm" : ""}
                            `}
                        >
                            {c("pricing_monthly_billing")}
                        </button>
                        <button
                            onClick={() => setPeriod("yearly")}
                            type="button"
                            className={`
                                relative w-1/2 whitespace-nowrap rounded-md py-2 text-sm font-medium text-gray-900
                                focus:z-10 focus:outline-none focus:ring-2 focus:ring-purple-500 sm:w-auto sm:px-8
                                ${period === "yearly" ? "border-gray-200 bg-white shadow-sm" : ""}
                            `}
                        >
                            {c("pricing_yearly_billing")}
                        </button>
                    </div>
                </div>

                <div
                    className="mt-12 space-y-4 sm:mt-16 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:mx-auto lg:max-w-4xl xl:mx-0 xl:max-w-none xl:grid-cols-4">
                    {plans.map((plan, key) => (
                        <PricingTable
                            key={`pricing-table-${key}`}
                            {...plan}
                            period={period}
                        />
                    ))}
                </div>

                <div className="mx-auto max-w-7xl py-16 px-4 sm:px-6 lg:py-24 lg:px-8">
                    <div className="mx-auto max-w-3xl text-center">
                        <h2 className="text-3xl font-bold tracking-tight text-gray-900">
                            {c("pricing_features_title")}
                        </h2>
                        <p className="mt-4 text-lg text-gray-500">
                            {c("pricing_features_description")}
                        </p>
                    </div>
                    <dl className="mt-12 space-y-10 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:grid-cols-4 lg:gap-x-8">
                        {features.map((feature, key) => (
                            <Feature {...feature} key={`feature-${key}`}/>
                        ))}
                    </dl>
                </div>
            </Container>

            <div className="bg-purple-600">
                <div className="mx-auto max-w-7xl py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                    <div className="lg:space-y-10">
                        <h2 className="text-3xl font-bold tracking-tight text-white">
                            {c("pricing_used_by")}
                        </h2>
                        <div className="mt-8 flow-root lg:mt-0">
                            <div className="-mt-4 -ml-8 flex flex-wrap justify-between lg:-ml-4">
                                {clients.map((client, key) => (
                                    <div key={`client-${key}`}
                                        className="mt-4 ml-8 flex flex-shrink-0 flex-grow lg:ml-4 lg:flex-grow-0">
                                        <img className="h-12" {...client} />
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="mx-auto max-w-7xl py-16 px-4 sm:px-6 lg:py-20 lg:px-8">
                <div className="lg:grid lg:grid-cols-3 lg:gap-8">
                    <div className="space-y-4">
                        <h2 className="text-3xl font-bold tracking-tight text-gray-900">
                            {c("pricing_faqs_header")}
                        </h2>
                        <p className="text-lg text-gray-500">
                            <Link to="/contact" className="font-medium text-purple-600 hover:text-purple-500">
                                {c("pricing_faqs_description")}
                            </Link>
                        </p>
                    </div>
                    <div className="mt-12 lg:col-span-2 lg:mt-0">
                        <dl className="space-y-12">
                            {faqs.map((faq, key) => (
                                <div key={`faq-${key}`}>
                                    <dt className="text-lg font-medium leading-6 text-gray-900">
                                        {c(faq.question)}
                                    </dt>
                                    <dd className="mt-2 text-base text-gray-500">
                                        {c(faq.answer)}
                                    </dd>
                                </div>
                            ))}
                        </dl>
                    </div>
                </div>
            </div>
        </MarketingLayout>
    );
};

const Feature = ({ title, description }) => {
    const { c } = useLanguage();

    return (
        <div className="relative">
            <dt>
                <FontAwesomeIcon icon={faCheck} className="absolute h-6 w-6 text-green-500"/>
                <p className="ml-9 text-lg font-medium leading-6 text-gray-900">{c(title)}</p>
            </dt>
            <dd className="mt-2 ml-9 flex text-base text-gray-500 lg:py-0 lg:pb-4">{c(description)}</dd>
        </div>
    );
};

Feature.propTypes = {
    title: PropTypes.string,
    description: PropTypes.string,
};

const PricingTable = ({ title, description, priceMonth, priceYear, period, features }) => {
    const { c } = useLanguage();

    return (
        <div className="divide-y divide-gray-200 rounded-lg border border-gray-200 shadow-sm">
            <div className="p-6">
                <h2 className="text-lg font-medium leading-6 text-gray-900">{c(title)}</h2>
                <p className="mt-4 text-sm text-gray-500">{c(description)}</p>
                {period === "monthly" && (
                    <p className="mt-8">
                        <span className="text-4xl font-bold tracking-tight text-gray-900">£{priceMonth}</span>
                        <span className="text-base font-medium text-gray-500">/mo</span>
                    </p>
                )}
                {period === "yearly" && (
                    <p className="mt-8">
                        <span className="text-4xl font-bold tracking-tight text-gray-900">£{priceYear}</span>
                        <span className="text-base font-medium text-gray-500">/yr</span>
                    </p>
                )}
                <Link
                    to="/register"
                    className="mt-8 block w-full rounded-md border border-transparent bg-purple-600 py-2 text-center text-sm font-semibold text-white hover:bg-purple-700">
                    {c("pricing_register_now")}
                </Link>
            </div>
            <div className="px-6 pt-6 pb-8">
                <h3 className="text-sm font-medium text-gray-900">{c("pricing_whats_included")}</h3>
                <ul role="list" className="mt-6 space-y-4">
                    {features.map((feature, key) => (
                        <li className="flex space-x-3" key={`feature-${key}`}>
                            <FontAwesomeIcon icon={faCheck} className="h-5 w-5 flex-shrink-0 text-green-500"/>
                            <span className="text-sm text-gray-500">
                                {c(feature)}
                            </span>
                        </li>
                    ))}
                </ul>
            </div>
        </div>
    );
};

PricingTable.propTypes = {
    title: PropTypes.string,
    description: PropTypes.string,
    priceMonth: PropTypes.number,
    priceYear: PropTypes.number,
    period: PropTypes.string,
    features: PropTypes.array,
};

export default Pricing;
