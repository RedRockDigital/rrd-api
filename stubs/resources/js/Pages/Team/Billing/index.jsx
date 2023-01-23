import React, { useEffect, useState } from "react";
import { Loading, useRequest } from "rrd-ui";

import TeamsLayout from "@/Components/Layouts/TeamsLayout";

import { BillingInformation, CardDetails, CurrentPlan, Invoices } from "./Partials";

const Billing = () => {
    const { get } = useRequest();

    const [loading, setLoading] = useState(true);
    const [currentCard, setCurrentCard] = useState(null);

    const fetchPaymentMethod = async () => {
        const request = await get("/billing/payment-method");

        if (request.success) {
            setCurrentCard(request.data.data ?? null);
        }

        setLoading(false);
    };

    useEffect(() => {
        fetchPaymentMethod();
    }, []);

    return (
        <TeamsLayout className="space-y-6">
            {loading && (
                <Loading />
            )}

            {!loading && (
                <>
                    <CurrentPlan
                        hasCard={!!currentCard}
                    />

                    <CardDetails
                        currentCard={currentCard}
                        fetchPaymentMethod={fetchPaymentMethod}
                    />

                    <BillingInformation />

                    <Invoices />
                </>
            )}
        </TeamsLayout>
    );
};

export default Billing;
