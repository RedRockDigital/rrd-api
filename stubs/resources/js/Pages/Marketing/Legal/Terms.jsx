import React from "react";
import { Container, useLanguage } from "rrd-ui";

import MarketingLayout from "@/Components/Layouts/Marketing";
import { Hero } from "@/Components/Partials";

const Terms = () => {
    const { c } = useLanguage();

    return (
        <MarketingLayout includeCta={false}>
            <Hero>
                <div className="text-center">
                    <h1 className="text-4xl tracking-tight font-extrabold text-gray-800 sm:text-5xl md:text-6xl">
                        {c("terms_title")}
                    </h1>
                </div>
            </Hero>

            <Container className="text-gray-500 py-24 space-y-4">
                <p>
                    Last updated: [insert date]
                </p>

                <p>
                    Line 1
                </p>

                <h3 className="font-bold text-2xl text-gray-800">
                    Heading
                </h3>
            </Container>
        </MarketingLayout>
    );
};

export default Terms;
