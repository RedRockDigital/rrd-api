import React from "react";
import PropTypes from "prop-types";
import { Container, useLanguage } from "rrd-ui";

import MarketingLayout from "@/Components/Layouts/Marketing";
import { Hero } from "@/Components/Partials";

import features from "@/Config/features";

const Roadmap = () => {
    const { c } = useLanguage();

    return (
        <MarketingLayout>
            <Hero>
                <div className="text-center">
                    <h1 className="text-4xl tracking-tight font-extrabold text-gray-800 sm:text-5xl md:text-6xl">
                        {c("roadmap_title")}
                    </h1>
                    <p className="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        {c("roadmap_description")}
                    </p>
                </div>
            </Hero>

            <Section
                title={c("roadmap_completed_title")}
                description={c("roadmap_completed_description")}
                features={features.filter(f => f.type === "completed")}
                darkMode={true}
            />
            <Section
                title={c("roadmap_in_progress_title")}
                description={c("roadmap_in_progress_description")}
                features={features.filter(f => f.type === "in-progress")}
                darkMode={false}
            />
            <Section
                title={c("roadmap_planned_title")}
                description={c("roadmap_planned_description")}
                features={features.filter(f => f.type === "planned")}
                darkMode={true}
            />
        </MarketingLayout>
    );
};

const Section = ({ title, description, features, darkMode = true }) => {
    if (features.length === 0) {
        return 0;
    }

    return (
        <div className={`${darkMode && "bg-gray-900"}`}>
            <Container className="py-12 lg:py-24">
                <div className="space-y-12">
                    <div className="space-y-5 sm:space-y-4 md:max-w-xl lg:max-w-3xl xl:max-w-none">
                        <h2 className={`text-3xl font-bold tracking-tight ${darkMode ? "text-white" : "text-black"} sm:text-4xl`}>
                            {title}
                        </h2>
                        <p className={`text-xl ${darkMode ? "text-gray-300" : "text-gray-800"}`}>
                            {description}
                        </p>
                    </div>
                    <ul className="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 lg:gap-8">
                        {features?.map((feature, key) => (
                            <li
                                className={`rounded-lg ${darkMode ? "bg-gray-800" : "bg-gray-100"} py-10 px-6 text-center xl:px-10 xl:text-left`}
                                key={key}
                            >
                                <div className="space-y-6 xl:space-y-10">
                                    <div className="space-y-2 xl:flex xl:items-center xl:justify-between">
                                        <div className="space-y-1 text-lg font-medium leading-6">
                                            <h3 className={`${darkMode ? "text-indigo-400" : "text-indigo-600"}`}>{feature.title}</h3>
                                            <p className={`${darkMode ? "text-white" : "text-gray-500"}`}>{feature.description}</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        ))}
                    </ul>
                </div>
            </Container>
        </div>
    );
};

Section.propTypes = {
    title: PropTypes.string,
    description: PropTypes.string,
    features: PropTypes.array,
    darkMode: PropTypes.bool,
};

export default Roadmap;
