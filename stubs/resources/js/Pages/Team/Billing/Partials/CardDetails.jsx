import React, { useState, useEffect } from "react";
import PropTypes from "prop-types";
import { Card, CardHeader, CardBody, CardFooter, PrimaryButton, Content, useLanguage } from "rrd-ui";

import { UpdateCardDetails } from "./";

const CardDetails = ({ fetchPaymentMethod, currentCard }) => {
    const { c } = useLanguage();
    const [showForm, setShowForm] = useState(!currentCard);

    const handleToggleForm = () => setShowForm(!showForm);

    useEffect(() => {
        const clientSecret = new URLSearchParams(window.location.search).get(
            "setup_intent_client_secret"
        );

        setShowForm(!!clientSecret);
    }, []);

    useEffect(() => {
        if (!currentCard) {
            setShowForm(true);
        }
    }, [currentCard]);

    return (
        <Card>
            {showForm && (
                <UpdateCardDetails
                    handleToggleForm={handleToggleForm}
                    handleRefresh={fetchPaymentMethod}
                />
            )}

            {!showForm && (
                <>
                    <CardHeader>{c("teams_billing_payment_information_title")}</CardHeader>

                    <CardBody>
                        <Content>
                            {c("teams_billing_payment_information_body", {
                                last_four: currentCard?.last4,
                                expires: `${currentCard?.exp_month}/${currentCard?.exp_year}`,
                            })}
                        </Content>
                    </CardBody>

                    <CardFooter className="flex justify-end">
                        <PrimaryButton onClick={handleToggleForm}>
                            {c("teams_billing_payment_information_update_details_button")}
                        </PrimaryButton>
                    </CardFooter>
                </>
            )}
        </Card>
    );
};

CardDetails.propTypes = {
    fetchPaymentMethod: PropTypes.func,
    currentCard: PropTypes.object,
};

export default CardDetails;
