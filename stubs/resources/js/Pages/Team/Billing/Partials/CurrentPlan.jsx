import React, { useState, useEffect } from "react";
import PropTypes from "prop-types";
import { Card, CardHeader, CardBody, CardFooter, PrimaryButton, Content, Loading, useLanguage, useRequest, useUser } from "rrd-ui";
import { DateTime } from "luxon";

import ChoosePlan from "./ChoosePlan";

const CurrentPlan = ({ hasCard }) => {
    const { c } = useLanguage();
    const { get } = useRequest();
    const { user } = useUser();

    const [loading, setLoading] = useState(true);
    const [currentPlan, setCurrentPlan] = useState(null);
    const [showChangePlan, setShowChangePlan] = useState(false);

    const fetchSubscription = async () => {
        setLoading(true);
        setShowChangePlan(false);

        const { success, data } = await get("/billing/subscription");

        if (success) {
            setCurrentPlan(data.data);
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchSubscription();
    }, []);

    const handleToggleShowChangePlan = () => setShowChangePlan(!showChangePlan);

    if (showChangePlan) {
        return (
            <ChoosePlan
                currentPlan={currentPlan}
                handleToggleShowChangePlan={handleToggleShowChangePlan}
                handleRefresh={fetchSubscription}
            />
        );
    }

    return (
        <Card>
            <CardHeader>{c("teams_billing_current_plan_title")}</CardHeader>

            <CardBody>
                {loading && (
                    <Loading />
                )}

                {!loading && (
                    <Content>
                        {c("teams_billing_current_plan_body", {
                            plan: user.current_team.tier.toLowerCase(),// currentPlan.name,
                            price: currentPlan.price,
                            next_payment_date: DateTime.fromISO(currentPlan.next_payment_date).toLocaleString(DateTime.DATE_MED),
                        })}
                    </Content>
                )}
            </CardBody>

            <CardFooter className="flex justify-end items-center">
                <div className="flex space-x-4">
                    {!hasCard && (
                        <p className="text-gray-500">Please add a card below before upgrading.</p>
                    )}

                    {hasCard && (
                        <PrimaryButton onClick={handleToggleShowChangePlan}>
                            {c("teams_billing_current_plan_change_button")}
                        </PrimaryButton>
                    )}
                </div>
            </CardFooter>
        </Card>
    );
};

CurrentPlan.propTypes = {
    hasCard: PropTypes.bool,
};

export default CurrentPlan;
