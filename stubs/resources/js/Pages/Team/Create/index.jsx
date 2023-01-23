import React from "react";
import { Card, CardHeader, CardBody, CardFooter, Input, PrimaryButton, Alert, Container, useRequest, useLanguage, useForm, useTeamSwitcher } from "rrd-ui";

import Authenticated from "@/Components/Layouts/Authenticated";

const Create = () => {
    const teamSwitcher = useTeamSwitcher();
    const { c } = useLanguage();
    const { post } = useRequest();
    const { alert, value, handleInput, handleSubmit } = useForm();

    const handleRequest = (form) => post("team", form);

    const handleSuccess = async (response) => {
        await teamSwitcher(response.data.data.id);
    };

    return (
        <Authenticated>
            <Container className="py-12">
                <Card>
                    <CardHeader>
                        {c("teams_create_header")}
                    </CardHeader>

                    <form onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}>
                        <CardBody className="space-y-4">
                            {alert && <Alert {...alert} />}

                            <Input
                                label={c("teams_create_name_field")}
                                value={value("name")}
                                onChange={handleInput}
                                name="name"
                            />
                        </CardBody>

                        <CardFooter className="flex justify-end">
                            <PrimaryButton>
                                {c("teams_create_submit_button")}
                            </PrimaryButton>
                        </CardFooter>
                    </form>
                </Card>
            </Container>
        </Authenticated>
    );
};

export default Create;
