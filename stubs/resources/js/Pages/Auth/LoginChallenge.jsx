import React from "react";
import { useNavigate } from "react-router-dom";
import { Input, Alert, Container, PrimaryButton, Card, CardHeader, CardBody, CardFooter, useForm, useRequest, useUser, useLanguage } from "rrd-ui";

import Unauthenticated from "@/Components/Layouts/Unauthenticated";

const LoginChallenge = () => {
    const { loadUser } = useUser();
    const { c } = useLanguage();

    const { value, handleInput, handleSubmit, working, alert } = useForm();
    const { post } = useRequest();

    const navigate = useNavigate();

    const handleRequest = (form) => post("/me/two-factor/verify", form);

    const handleSuccess = async () => {
        await loadUser();

        navigate("/");
    };

    return (
        <Unauthenticated>
            <Container sizeClassName="max-w-xl">
                <Card>
                    <form
                        className="login-form"
                        onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}
                    >
                        <CardHeader>
                            {c("login_challenge_header")}
                        </CardHeader>

                        <CardBody className="space-y-4">
                            <p>{c("login_challenge_body")}</p>

                            {alert && (<Alert {...alert} />)}

                            <Input
                                name="code"
                                label={c("login_challenge_code")}
                                value={value("code")}
                                onChange={handleInput}
                            />
                        </CardBody>

                        <CardFooter className="flex justify-end">
                            <PrimaryButton
                                working={working}
                                ready={value("code")}
                            >
                                {c("login")}
                            </PrimaryButton>
                        </CardFooter>
                    </form>
                </Card>
            </Container>
        </Unauthenticated>
    );
};

export default LoginChallenge;
