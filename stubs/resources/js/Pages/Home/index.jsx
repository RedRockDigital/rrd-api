import React from "react";
import { Link } from "react-router-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faStar } from "@fortawesome/free-solid-svg-icons/faStar";
import { Container, PrimaryButton, SecondaryButton, useLanguage } from "rrd-ui";

import Marketing from "@/Components/Layouts/Marketing";
import { Hero } from "@/Components/Partials";

const Home = () => {
    const { c } = useLanguage();

    return (
        <Marketing>
            <Hero>
                <div className="text-center">
                    <h1 className="text-4xl tracking-tight font-extrabold text-gray-800 sm:text-5xl md:text-6xl">
                        <span className="block xl:inline">{c("home_header_1")}</span> <span
                            className="block text-indigo-600 xl:inline">{c("home_header_2")}</span>
                    </h1>
                    <p className="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        {c("home_intro")}
                    </p>
                    <div className="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                        <div className="rounded-md shadow">
                            <Link to="/register">
                                <PrimaryButton>
                                    {c("home_get_started")}
                                </PrimaryButton>
                            </Link>
                        </div>

                        <div className="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                            <Link to="/contact">
                                <SecondaryButton>
                                    {c("home_request_a_demo")}
                                </SecondaryButton>
                            </Link>
                        </div>
                    </div>
                </div>
            </Hero>

            <div className="overflow-hidden bg-gray-50 py-16 lg:py-24">
                <Container className="relative">
                    <div className="relative mt-12 lg:mt-24 lg:grid lg:grid-cols-2 lg:items-center lg:gap-8">
                        <div className="relative">
                            <h3 className="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                                {c("home_section_1_title")}
                            </h3>
                            <p className="mt-3 text-lg text-gray-500">{c("home_section_1_description")}</p>

                            <dl className="mt-10 space-y-10">
                                <div className="relative">
                                    <dt>
                                        <div
                                            className="absolute flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-500 text-white">
                                            <FontAwesomeIcon icon={faStar} className="w-8 h-8" />
                                        </div>
                                        <p className="ml-16 text-lg font-medium leading-6 text-gray-900">
                                            {c("home_section_1_feature_1_title")}
                                        </p>
                                    </dt>
                                    <dd className="mt-2 ml-16 text-base text-gray-500">
                                        {c("home_section_1_feature_1_description")}
                                    </dd>
                                </div>

                                <div className="relative">
                                    <dt>
                                        <div
                                            className="absolute flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-500 text-white">
                                            <FontAwesomeIcon icon={faStar} className="w-8 h-8" />
                                        </div>
                                        <p className="ml-16 text-lg font-medium leading-6 text-gray-900">
                                            {c("home_section_1_feature_2_title")}
                                        </p>
                                    </dt>
                                    <dd className="mt-2 ml-16 text-base text-gray-500">
                                        {c("home_section_1_feature_2_description")}
                                    </dd>
                                </div>

                                <div className="relative">
                                    <dt>
                                        <div
                                            className="absolute flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-500 text-white">
                                            <FontAwesomeIcon icon={faStar} className="w-8 h-8" />
                                        </div>
                                        <p className="ml-16 text-lg font-medium leading-6 text-gray-900">
                                            {c("home_section_1_feature_3_title")}
                                        </p>
                                    </dt>
                                    <dd className="mt-2 ml-16 text-base text-gray-500">
                                        {c("home_section_1_feature_3_description")}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div className="relative -mx-4 mt-10 lg:mt-0" aria-hidden="true">
                            <svg className="absolute left-1/2 -translate-x-1/2 translate-y-16 transform lg:hidden"
                                width="784" height="404" fill="none" viewBox="0 0 784 404">
                                <defs>
                                    <pattern id="ca9667ae-9f92-4be7-abcb-9e3d727f2941" x="0" y="0" width="20"
                                        height="20" patternUnits="userSpaceOnUse">
                                        <rect x="0" y="0" width="4" height="4" className="text-gray-200"
                                            fill="currentColor"/>
                                    </pattern>
                                </defs>
                                <rect width="784" height="404" fill="url(#ca9667ae-9f92-4be7-abcb-9e3d727f2941)"/>
                            </svg>
                            <img className="relative mx-auto" width="490"
                                src="https://tailwindui.com/img/features/feature-example-1.png" alt="" />
                        </div>
                    </div>

                    <svg className="absolute right-full hidden translate-x-1/2 translate-y-12 transform lg:block"
                        width="404" height="784" fill="none" viewBox="0 0 404 784" aria-hidden="true">
                        <defs>
                            <pattern id="64e643ad-2176-4f86-b3d7-f2c5da3b6a6d" x="0" y="0" width="20" height="20"
                                patternUnits="userSpaceOnUse">
                                <rect x="0" y="0" width="4" height="4" className="text-gray-200" fill="currentColor"/>
                            </pattern>
                        </defs>
                        <rect width="404" height="784" fill="url(#64e643ad-2176-4f86-b3d7-f2c5da3b6a6d)"/>
                    </svg>

                    <div className="relative mt-12 sm:mt-16 lg:mt-24">
                        <div className="lg:grid lg:grid-flow-row-dense lg:grid-cols-2 lg:items-center lg:gap-8">
                            <div className="lg:col-start-2">
                                <h3 className="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                                    {c("home_section_2_title")}
                                </h3>

                                <p className="mt-3 text-lg text-gray-500">
                                    {c("home_section_2_description")}
                                </p>

                                <dl className="mt-10 space-y-10">
                                    <div className="relative">
                                        <dt>
                                            <div
                                                className="absolute flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-500 text-white">
                                                <FontAwesomeIcon icon={faStar} className="w-8 h-8" />
                                            </div>
                                            <p className="ml-16 text-lg font-medium leading-6 text-gray-900">
                                                {c("home_section_2_feature_1_title")}
                                            </p>
                                        </dt>
                                        <dd className="mt-2 ml-16 text-base text-gray-500">
                                            {c("home_section_2_feature_1_description")}
                                        </dd>
                                    </div>

                                    <div className="relative">
                                        <dt>
                                            <div
                                                className="absolute flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-500 text-white">
                                                <FontAwesomeIcon icon={faStar} className="w-8 h-8" />
                                            </div>
                                            <p className="ml-16 text-lg font-medium leading-6 text-gray-900">
                                                {c("home_section_2_feature_2_title")}
                                            </p>
                                        </dt>
                                        <dd className="mt-2 ml-16 text-base text-gray-500">
                                            {c("home_section_2_feature_2_description")}
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <div className="relative -mx-4 mt-10 lg:col-start-1 lg:mt-0">
                                <svg className="absolute left-1/2 -translate-x-1/2 translate-y-16 transform lg:hidden"
                                    width="784" height="404" fill="none" viewBox="0 0 784 404" aria-hidden="true">
                                    <defs>
                                        <pattern id="e80155a9-dfde-425a-b5ea-1f6fadd20131" x="0" y="0" width="20"
                                            height="20" patternUnits="userSpaceOnUse">
                                            <rect x="0" y="0" width="4" height="4" className="text-gray-200"
                                                fill="currentColor"/>
                                        </pattern>
                                    </defs>
                                    <rect width="784" height="404" fill="url(#e80155a9-dfde-425a-b5ea-1f6fadd20131)"/>
                                </svg>
                                <img className="relative mx-auto" width="490"
                                    src="https://tailwindui.com/img/features/feature-example-2.png" alt="" />
                            </div>
                        </div>
                    </div>
                </Container>
            </div>
        </Marketing>
    );
};

export default Home;
