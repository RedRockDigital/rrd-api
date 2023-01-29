import React from "react";
import { Card, CardHeader, CardBody, CardFooter, PrimaryButton, Input, Alert, useForm, useLanguage, useRequest } from "rrd-ui";

import SettingsLayout from "@/Components/Layouts/SettingsLayout";

const Password = () => {
    const { value, alert, working, handleInput, setAlert, handleSubmit, resetForm } = useForm();
    const { c } = useLanguage();
    const { patch } = useRequest();

    const handleRequest = (form) => patch("me/password", form);

    const handleSuccess = async () => {
        await setAlert({
            type: "success",
            message: c("settings_password_success"),
        });

        await resetForm();
    };

    return (
        <SettingsLayout>
            <form onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}>
                <Card>
                    <CardHeader>
                        {c("settings_password_header")}
                    </CardHeader>

                    <CardBody className="space-y-4">
                        {alert && (<Alert {...alert} />)}

                        <Input
                            type="password"
                            label={c("current_password")}
                            name="current_password"
                            value={value("current_password")}
                            onChange={handleInput}
                        />

                        <div className="grid md:grid-cols-2 gap-4">
                            <Input
                                type="password"
                                label={c("new_password")}
                                name="password"
                                value={value("password")}
                                onChange={handleInput}
                            />
                            <Input
                                type="password"
                                label={c("password_confirmation")}
                                name="password_confirmation"
                                value={value("password_confirmation")}
                                onChange={handleInput}
                            />
                        </div>
                    </CardBody>

                    <CardFooter className="flex justify-end">
                        <PrimaryButton working={working}>{c("save")}</PrimaryButton>
                    </CardFooter>
                </Card>
            </form>
        </SettingsLayout>
    );
};

export default Password;
