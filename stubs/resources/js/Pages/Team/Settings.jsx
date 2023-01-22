import React, { useEffect } from "react";
import { Card, CardHeader, CardBody, CardFooter, Alert, PrimaryButton, Input, useLanguage, useForm, useUser, useRequest } from "rrd-ui";

import TeamsLayout from "@/Components/Layouts/TeamsLayout";

const Settings = () => {
    const { c } = useLanguage();
    const { user, loadUser } = useUser();
    const { patch } = useRequest();
    const { value, alert, working, handleInput, handleSubmit, setForm, setAlert } = useForm();

    useEffect(() => {
        if (user?.current_team) {
            setForm({
                name: user?.current_team?.name,
            });
        }
    }, [setForm, user?.current_team]);

    const handleRequest = (form) => patch(`team/${user?.current_team.id}`, form);

    const handleSuccess = async () => {
        await loadUser();

        setAlert({
            type: "success",
            message: c("team_settings_updated_success"),
        });
    };

    return (
        <TeamsLayout>
            <Card>
                <form onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}>
                    <CardHeader>
                        {c("teams_settings_title")}
                    </CardHeader>

                    <CardBody className="space-y-4">
                        {alert && (<Alert {...alert} />)}

                        <Input
                            label={c("team_settings_name")}
                            value={value("name")}
                            onChange={handleInput}
                            name="name"
                        />
                    </CardBody>

                    <CardFooter className="flex justify-end">
                        <PrimaryButton working={working}>
                            {c("teams_settings_update_button")}
                        </PrimaryButton>
                    </CardFooter>
                </form>
            </Card>
        </TeamsLayout>
    );
};

export default Settings;
