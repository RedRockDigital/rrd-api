import React, { useEffect } from "react";
import pick from "lodash/pick";
import { Card, CardHeader, CardBody, CardFooter, PrimaryButton, Input, Alert, useUser, useForm, useLanguage, useRequest } from "rrd-ui";

import SettingsLayout from "@/Components/Layouts/SettingsLayout";

const Profile = () => {
    const {
        value,
        alert,
        working,
        setForm,
        handleInput,
        setAlert,
        handleSubmit,
    } = useForm();
    const { c } = useLanguage();
    const { patch } = useRequest();
    const { user, loadUser } = useUser();

    useEffect(() => {
        if (user) {
            setForm({
                ...pick(user, ["first_name", "last_name", "email"]),
            });
        }
    }, [setForm, user]);

    const handleRequest = (form) => patch("me", form);

    const handleSuccess = async () => {
        await loadUser();

        setAlert({
            type: "success",
            message: c("settings_profile_success"),
        });
    };

    return (
        <SettingsLayout>
            <form onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}>
                <Card>
                    <CardHeader>
                        {c("settings_profile_header")}
                    </CardHeader>

                    <CardBody className="space-y-4">
                        {alert && (<Alert {...alert} />)}

                        <div className="grid gap-4 md:grid-cols-2">
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
                            type="email"
                            label={c("email")}
                            name="email"
                            value={value("email")}
                            onChange={handleInput}
                        />
                    </CardBody>

                    <CardFooter className="flex justify-end">
                        <PrimaryButton working={working}>{c("save")}</PrimaryButton>
                    </CardFooter>
                </Card>
            </form>
        </SettingsLayout>
    );
};

export default Profile;
