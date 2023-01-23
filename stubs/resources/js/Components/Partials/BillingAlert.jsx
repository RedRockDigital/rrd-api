import React from "react";
import { Link } from "react-router-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faExclamation } from "@fortawesome/free-solid-svg-icons/faExclamation";

import { Container, useUser, useLanguage } from "rrd-ui";
import { DateTime } from "luxon";

const BillingAlert = () => {
    const { c } = useLanguage();
    const { user } = useUser();

    if (!user?.current_team?.subscription.is_trial) {
        return null;
    }

    return (
        <div className="bg-yellow-500">
            <Container className="py-3">
                <div className="flex flex-wrap items-center justify-between">
                    <div className="flex w-0 flex-1 items-center">
                        <span className="flex rounded-lg bg-yellow-600 p-2">
                            <FontAwesomeIcon icon={faExclamation} className="h-6 w-6 text-white" />
                        </span>
                        <p className="ml-3 truncate font-medium text-white">
                            {c("billing_trial_ends", {
                                date: DateTime.fromISO(!user?.current_team?.subscription?.trial_end).toLocaleString(DateTime.DATE_MED),
                            })}
                        </p>
                    </div>
                    <div className="order-3 mt-2 w-full flex-shrink-0 sm:order-2 sm:mt-0 sm:w-auto">
                        <Link
                            to="/team/billing"
                            className="flex items-center justify-center rounded-md border border-transparent bg-white px-4 py-2 text-sm font-medium text-indigo-600 shadow-sm hover:bg-indigo-50"
                        >
                            Manage Billing
                        </Link>
                    </div>
                </div>
            </Container>
        </div>
    );
};

export default BillingAlert;
