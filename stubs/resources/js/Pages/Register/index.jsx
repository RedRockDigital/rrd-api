import React, { useEffect, useState } from "react";
import { Card, CardHeader, CardBody, CardFooter, Input, PrimaryButton, Container, Alert, Link, Complete, useForm, useLanguage, useRequest } from "rrd-ui";

import Unauthenticated from "@/Components/Layouts/Unauthenticated";

const Register = () => {
    const [completed, setCompleted] = useState(false);
    const { value, alert, working, handleSubmit, handleInput, setFieldValue } = useForm();
    const { post } = useRequest();
    const { c } = useLanguage();

    useEffect(() => {
        if (typeof rewardful !== "undefined") {
            rewardful("ready", function () {
                if (Rewardful.referral) {
                    setFieldValue("referral", Rewardful.referral);
                }
            });
        }
    }, []);

    const handleRequest = (form) => post("register", form);

    return (
        <Unauthenticated>
            <Container sizeClassName="max-w-xl">
                {completed && (
                    <Complete
                        title={c("sign_up_successful")}
                        message={c("sign_up_successful_message")}
                    />
                )}

                {!completed && (
                    <Card>
                        <form
                            onSubmit={(e) => handleSubmit(e, handleRequest, () => setCompleted(true))}
                        >
                            <CardHeader>{c("register_header")}</CardHeader>

                            <CardBody className="space-y-4">
                                {alert && (<Alert {...alert} />)}

                                <div className="grid md:grid-cols-2 grid-cols-1 gap-4">
                                    <Input
                                        label={c("first_name")}
                                        name="first_name"
                                        value={value("first_name")}
                                        onChange={handleInput}
                                    />
                                    <Input
                                        label={c("last_name")}
                                        name="last_name"
                                        value={value("last_name")}
                                        onChange={handleInput}
                                    />
                                </div>

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

                            <CardFooter className="flex justify-end">
                                <PrimaryButton working={working}>
                                    {c("register_submit")}
                                </PrimaryButton>
                            </CardFooter>
                        </form>
                    </Card>
                )}

                <p className="text-center text-gray-400 mt-6">
                    {c("login_already_got_account")} <Link to="/login">{c("login_already_got_account_link")}</Link>
                </p>
            </Container>
        </Unauthenticated>
    );
};

export default Register;
