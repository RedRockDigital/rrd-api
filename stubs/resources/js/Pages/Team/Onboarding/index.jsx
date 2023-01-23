import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import { Card, CardHeader, CardBody, CardFooter, PrimaryButton, SecondaryButton, Container, useUser, useRequest, useToast, useLanguage } from "rrd-ui";

import Authenticated from "@/Components/Layouts/Authenticated";

const Onboarding = () => {
    const [working, setWorking] = useState(false);

    const { c } = useLanguage();
    const { loadUser } = useUser();
    const { patch } = useRequest();
    const { success } = useToast();
    const navigate = useNavigate();

    const handleOnboardingComplete = async () => {
        const request = await patch("team/onboarded");

        if (request.success) {
            await loadUser();

            success();

            navigate("/");
        } else {
            setWorking(false);
        }
    };

    return (
        <Authenticated>
            <Container className="py-12">
                <Card>
                    <CardHeader>
                        Onboarding...
                    </CardHeader>

                    <CardBody>
                        Create onboarding steps here...
                    </CardBody>

                    <CardFooter className="flex justify-end space-x-2">
                        <SecondaryButton working={working} onClick={handleOnboardingComplete}>
                            {c("skip")}
                        </SecondaryButton>

                        <PrimaryButton working={working} onClick={handleOnboardingComplete}>
                            Next/Complete
                        </PrimaryButton>
                    </CardFooter>
                </Card>
            </Container>
        </Authenticated>
    );
};

export default Onboarding;
