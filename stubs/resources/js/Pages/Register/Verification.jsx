import React from "react";
import { Container, Card, CardBody, CardHeader, useLanguage } from "rrd-ui";

import Authenticated from "@/Components/Layouts/Authenticated";

const Verification = () => {
    const { c } = useLanguage();

    return (
        <Authenticated>
            <Container className="py-12">
                <Card>
                    <CardHeader>
                        {c("verification_header")}
                    </CardHeader>

                    <CardBody>
                        {c("verification_description")}
                    </CardBody>
                </Card>
            </Container>
        </Authenticated>
    );
};

export default Verification;
