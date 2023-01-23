import React, { useState } from "react";
import { Card, CardHeader, CardBody, CardFooter, Input, PrimaryButton, Container, Alert, Link, Complete, useRequest, useForm, useLanguage } from "rrd-ui";

import Unauthenticated from "@/Components/Layouts/Unauthenticated";

const ForgotPassword = () => {
    const { c } = useLanguage();
    const { value, alert, working, handleSubmit, handleInput } = useForm();
    const { post } = useRequest();

    const [completed, setCompleted] = useState(false);

    const handleRequest = (data) => post("/forgot-password", data);

    const handleSuccess = () => setCompleted(true);

    return (
        <Unauthenticated>
            <Container sizeClassName="max-w-xl">
                {completed && (
                    <Complete
                        title={c("password_forgot_success")}
                        message={c("password_forgot_success_message")}
                    />
                )}
                {!completed && (
                    <Card>
                        <form onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}>
                            <CardHeader>{c("forgot_password_header")}</CardHeader>

                            <CardBody className="space-y-4">
                                {alert && (<Alert {...alert} />)}

                                <Input
                                    label={c("email")}
                                    name="email"
                                    type="email"
                                    value={value("email")}
                                    onChange={handleInput}
                                />
                            </CardBody>

                            <CardFooter className="flex justify-between items-center">
                                <Link to="/login">
                                    {c("back_to_login_link")}
                                </Link>

                                <PrimaryButton working={working}>
                                    {c("submit")}
                                </PrimaryButton>
                            </CardFooter>
                        </form>
                    </Card>
                )}

                <p className="text-center text-gray-400 mt-6">
                    <Link to="/login">{c("back_to_login")}</Link>
                </p>
            </Container>
        </Unauthenticated>
    );
};

export default ForgotPassword;
