import React from "react";
import { Link } from "react-router-dom";
import { HasAccess, NoAccess, Container, ErrorState, PrimaryButton, useLanguage } from "rrd-ui";

import AuthenticatedLayout from "@/Components/Layouts/Authenticated";

const scope = "team.manage-billing";

const Failed = () => {
    const { c } = useLanguage();

    return (
        <AuthenticatedLayout>
            <HasAccess scope={scope}>
                <Container className="py-12" sizeClassName="max-w-xl">
                    <ErrorState
                        title={c("team_billing_failed_header")}
                        message={c("team_billing_failed_admin_message")}
                    >
                        <Link to="/team/billing">
                            <PrimaryButton>
                                {c("team_billing_link")}
                            </PrimaryButton>
                        </Link>
                    </ErrorState>
                </Container>
            </HasAccess>

            <NoAccess scope={scope}>
                <Container className="py-12" sizeClassName="max-w-xl">
                    <ErrorState
                        title={c("team_billing_failed_header")}
                        message={c("team_billing_failed_user_message")}
                    />
                </Container>
            </NoAccess>
        </AuthenticatedLayout>
    );
};

export default Failed;
