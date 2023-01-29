import React, { useState } from "react";
import PropTypes from "prop-types";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faCheck } from "@fortawesome/free-solid-svg-icons/faCheck";
import { faArrowLeft } from "@fortawesome/free-solid-svg-icons/faArrowLeft";
import { PrimaryButton, DangerButton, useLanguage, useRequest, useUser } from "rrd-ui";

const tiers = [ // TODO should go to a central config file.
    {
        tier: "PERSONAL",
        name: "personal_tier_name",
        description: "personal_tier_description",
        price: window.app.tiers.PERSONAL.price,
        // priceMonthly: 14,
        // priceYearly: 140,
        includedFeatures: [
            "personal_tier_feature_one",
            "personal_tier_feature_two",
            "personal_tier_feature_three",
        ],
    },
    {
        tier: "SMALL",
        name: "small_tier_name",
        description: "small_tier_description",
        price: window.app.tiers.SMALL.price,
        // priceMonthly: 21,
        // priceYearly: 210,
        includedFeatures: [
            "small_tier_feature_one",
            "small_tier_feature_two",
            "small_tier_feature_three",
        ],
    },
    {
        tier: "GROWTH",
        name: "growth_tier_name",
        description: "growth_tier_description",
        price: window.app.tiers.GROWTH.price,
        // priceMonthly: 21,
        // priceYearly: 210,
        includedFeatures: [
            "growth_tier_feature_one",
            "growth_tier_feature_two",
            "growth_tier_feature_three",
        ],
    },
];

const ChoosePlan = ({ handleRefresh, currentPlan, onboarding, handleToggleShowChangePlan }) => {
    const { c } = useLanguage();
    const { patch } = useRequest();
    const { loadUser } = useUser();

    const [purchase, setPurchase] = useState();
    const [working, setWorking] = useState(false);

    const handleSelectTier = async (tier) => {
        if (purchase?.tier === tier?.tier) {
            setWorking(true);

            const { success } = await patch("/billing/subscription/change", {
                tier: purchase?.tier,
            });

            if (success) {
                await loadUser();

                if (handleRefresh) {
                    handleRefresh();
                }
            }

            setWorking(false);
        } else {
            setPurchase(tier);
        }
    };

    return (
        <>
            <div className="sm:align-center sm:flex sm:flex-col">
                <h1 className="text-5xl font-bold tracking-tight text-gray-900 sm:text-center">
                    {c("teams_billing_choose_plan_title")}
                </h1>
                <p className="mt-5 text-xl text-gray-500 sm:text-center">
                    {c("teams_billing_choose_plan_body")}
                </p>
            </div>
            <div className="mt-12 space-y-4 sm:mt-16 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:mx-auto lg:max-w-4xl xl:mx-0 xl:max-w-none xl:grid-cols-3">
                {tiers.map((tier) => (
                    <div key={tier.name} className="divide-y divide-gray-200 border border-gray-200 shadow-sm bg-white rounded-lg">
                        <div className="p-6">
                            <h2 className="text-lg font-medium leading-6 text-gray-900">{c(tier.name)}</h2>
                            <p className="mt-4 text-sm text-gray-500">{c(tier.description)}</p>
                            <p className="mt-8">
                                <span className="text-4xl font-bold tracking-tight text-gray-900">£{tier.price}</span>{" "}
                                <span className="text-base font-medium text-gray-500">/mo</span>
                            </p>
                            <PrimaryButton
                                className={`mt-4 ${purchase?.tier === tier.tier && "ring-2 ring-indigo-500 bg-indigo-800"}`}
                                disabled={currentPlan.tier === tier.tier}
                                onClick={() => handleSelectTier(tier)}
                                working={working}
                            >
                                {purchase?.tier === tier.tier
                                    ? (
                                            <>
                                                {c("teams_billing_confirm_purchase")}
                                            </>
                                        )
                                    : (
                                            <>
                                                {c(currentPlan.tier === tier.tier
                                                    ? "teams_billing_choose_plan_current_plan"
                                                    : "teams_billing_choose_plan_buy", {
                                                    plan: c(tier.name),
                                                })}
                                            </>
                                        )}
                            </PrimaryButton>
                        </div>
                        <div className="px-6 pt-6 pb-8">
                            <h3 className="text-sm font-medium text-gray-900">{c("teams_billing_choose_plan_whats_included")}</h3>
                            <ul role="list" className="mt-6 space-y-4">
                                {tier.includedFeatures.map((feature) => (
                                    <li key={feature} className="flex space-x-3">
                                        <FontAwesomeIcon icon={faCheck} className="h-5 w-5 flex-shrink-0 text-green-500" aria-hidden="true" />
                                        <span className="text-sm text-gray-500">{c(feature)}</span>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    </div>
                ))}
            </div>

            <div className="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <h2 className="text-lg font-medium leading-6 text-gray-900">{c("free_tier_title")}</h2>
                <p className="mt-4 text-sm text-gray-500">{c("free_tier_description")}</p>

                <DangerButton
                    working={working}
                    className={`mt-4 ${purchase?.tier === "FREE" && "ring-2 ring-rose-500 bg-rose-800"}`}
                    onClick={() => handleSelectTier({ tier: "FREE" })}
                >
                    {purchase?.tier === "FREE"
                        ? (
                                <>
                                    {c("teams_billing_confirm_downgrade")}
                                </>
                            )
                        : (
                                <>
                                    {c(currentPlan.tier === "FREE"
                                        ? "teams_billing_choose_plan_current_plan"
                                        : "free_tier_downgrade_button", {
                                        plan: "Free",
                                    })}
                                </>
                            )}
                </DangerButton>
            </div>

            {handleToggleShowChangePlan && !onboarding && (
                <div onClick={handleToggleShowChangePlan} className="text-gray-500 text-sm cursor-pointer underline">
                    <FontAwesomeIcon icon={faArrowLeft} /> {c("teams_billing_choose_plan_cancel")}
                </div>
            )}
        </>
    );
};

ChoosePlan.propTypes = {
    onboarding: PropTypes.bool,
    handleToggleShowChangePlan: PropTypes.func,
    currentPlan: PropTypes.object,
    handleRefresh: PropTypes.func,
};

export default ChoosePlan;
