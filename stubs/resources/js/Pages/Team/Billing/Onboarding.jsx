import React, { useState } from "react";
import { Complete, useLanguage } from "rrd-ui";

import Authenticated from "@/Components/Layouts/Authenticated";

import { UpdateCardDetails, ChoosePlan } from "./Partials";

const Onboarding = () => {
    const { c } = useLanguage();

    const [stage, setStage] = useState("card-details");

    return (
        <Authenticated>
            <main className="mx-auto max-w-7xl pb-10 lg:py-12 lg:px-8">
                {stage === "card-details" && (
                    <UpdateCardDetails
                        onboarding={true}
                        handleComplete={() => setStage("choose-plan")}
                    />
                )}

                {stage === "choose-plan" && (
                    <ChoosePlan
                        onboarding={true}
                        handleComplete={() => setStage("completed")}
                    />
                )}

                {stage === "completed" && (
                    <Complete
                        title={c("teams_billing_onboarding_complete_title")}
                        message={c("teams_billing_onboarding_complete_message")}
                    />
                )}
            </main>
        </Authenticated>
    );
};

export default Onboarding;
