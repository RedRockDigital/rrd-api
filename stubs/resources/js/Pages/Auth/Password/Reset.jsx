import React, { useState } from "react";
import { useParams } from "react-router-dom";
import { Card, CardHeader, CardBody, CardFooter, Input, PrimaryButton, Container, Alert, Link, Complete, useRequest, useForm, useLanguage } from "rrd-ui";

import Unauthenticated from "@/Components/Layouts/Unauthenticated";

const ResetPassword = () => {
    const { c } = useLanguage();
    const { value, alert, working, handleSubmit, handleInput } = useForm();
    const { patch } = useRequest();
    const params = useParams();

    const [completed, setCompleted] = useState(false);

    const handleRequest = (form) => patch("reset-password", {
        ...form,
        ...params,
    });

    const handleSuccess = () => setCompleted(true);

    return (
        <Unauthenticated>
            <Container sizeClassName="max-w-xl">
                {completed && (
                    <Complete
                        title={c("password_reset_success")}
                        message={c("password_reset_success_message")}
                    />
                )}

                {!completed && (
                    <Card>
                        <form onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}>
                            <CardHeader>{c("reset_password_header")}</CardHeader>

                            <CardBody className="space-y-4">
                                {alert && (<Alert {...alert} />)}

                                <Input
                                    label={c("email")}
                                    name="email"
                                    type="email"
                                    value={value("email")}
                                    onChange={handleInput}
                                />

                                <div className="grid md:grid-cols-2 grid-cols-1 gap-4">
                                    <Input
                                        label={c("password")}
                                        type="password"
                                        name="password"
                                        value={value("password")}
                                        onChange={handleInput}
                                    />
                                    <Input
                                        label={c("password_confirmation")}
                                        type="password"
                                        name="password_confirmation"
                                        value={value("password_confirmation")}
                                        onChange={handleInput}
                                    />
                                </div>
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

export default ResetPassword;
