import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import { loadStripe } from "@stripe/stripe-js";
import { useNavigate } from "react-router-dom";
import { Elements as StripeElements, PaymentElement, useStripe, useElements } from "@stripe/react-stripe-js";
import { Loading, Card, CardBody, CardFooter, CardHeader, PrimaryButton, SecondaryButton, Alert, useLanguage, useRequest } from "rrd-ui";

const stripePromise = loadStripe(import.meta.env.VITE_STRIPE_PUBLISHABLE_KEY);

const UpdateCardDetails = ({ onboarding, handleToggleForm, handleRefresh }) => {
    const { c } = useLanguage();
    const [working, setWorking] = useState(true);
    const [clientSecret, setClientSecret] = useState("");
    const { post } = useRequest();

    useEffect(() => {
        (async () => {
            setWorking(true);

            const request = await post("/billing/intents");

            if (request.success) {
                console.log(request.data.data);
                setClientSecret(request.data.data.client_secret);
                setWorking(false);
            }
        })();
    }, []);

    if (working) {
        return (<Loading />);
    }

    return (
        <Card>
            <CardHeader>{c("teams_billing_payment_information_title")}</CardHeader>

            <StripeElements
                options={{
                    clientSecret,
                    appearance: {
                        theme: "stripe",
                    },
                }}
                stripe={stripePromise}
            >
                <Form
                    onboard={onboarding}
                    handleRefresh={handleRefresh}
                    handleToggleForm={handleToggleForm}
                />
            </StripeElements>
        </Card>
    );
};

UpdateCardDetails.propTypes = {
    onboarding: PropTypes.bool,
    handleToggleForm: PropTypes.func,
    handleRefresh: PropTypes.func,
};

const Form = ({ onboarding, handleToggleForm }) => {
    const { c } = useLanguage();
    const { post } = useRequest();
    const stripe = useStripe();
    const elements = useElements();
    const navigate = useNavigate();

    const [message, setMessage] = useState(null);
    const [working, setWorking] = useState(false);

    useEffect(() => {
        if (!stripe) {
            return;
        }

        const clientSecret = new URLSearchParams(window.location.search).get(
            "setup_intent_client_secret"
        );

        if (!clientSecret) {
            return;
        }

        stripe.retrieveSetupIntent(clientSecret).then(async ({ setupIntent }) => {
            if (setupIntent.status === "succeeded") {
                const request = await post("/billing/payment-method", {
                    pm: setupIntent.payment_method,
                });

                if (request.success) {
                    // Force reload of the page
                    navigate("/team/billing");
                    navigate(0);

                    return;
                }
            }

            setMessage({
                type: "error",
                message: "Failed to process payment details. Please try another payment method.",
            });
        });
    }, [stripe]);

    const handleSubmit = async (e) => {
        e.preventDefault();

        if (!stripe || !elements) {
            return;
        }

        setWorking(true);

        const { error } = await stripe.confirmSetup({
            elements,
            confirmParams: {
                return_url: window.location.href,
            },
        });

        if (error.type === "card_error" || error.type === "validation_error") {
            setMessage({
                type: "error",
                message: error.message,
            });
        } else {
            setMessage({
                type: "error",
                message: "An unexpected error occurred.",
            });
        }

        setWorking(false);
    };

    return (
        <Card>
            <form onSubmit={handleSubmit}>
                <CardBody className="space-y-4">
                    {message && (<Alert {...message} />)}

                    <PaymentElement
                        id="payment-element"
                        options={{
                            layout: "tabs",
                        }}
                    />
                </CardBody>

                <CardFooter className="flex justify-end space-x-4">
                    {!onboarding && (
                        <SecondaryButton onClick={handleToggleForm}>
                            {c("teams_billing_payment_information_cancel_button")}
                        </SecondaryButton>
                    )}

                    <PrimaryButton
                        disabled={!stripe || !elements}
                        working={working}
                    >
                        {c("teams_billing_payment_information_update_button")}
                    </PrimaryButton>
                </CardFooter>
            </form>
        </Card>
    );
};

Form.propTypes = {
    onboarding: PropTypes.bool,
    handleToggleForm: PropTypes.func,
    handleRefresh: PropTypes.func,
};

export default UpdateCardDetails;
