import React, { useEffect } from "react";
import { Card, CardHeader, CardBody, CardFooter, PrimaryButton, Content, Textarea, Alert, useLanguage, useForm, useRequest, useUser, useToast } from "rrd-ui";

const BillingInformation = () => {
    const { user, loadUser } = useUser();
    const { c } = useLanguage();
    const { alert, working, value, handleInput, setFieldValue, handleSubmit } = useForm();
    const { patch } = useRequest();
    const { success } = useToast();

    useEffect(() => {
        if (user?.current_team) {
            setFieldValue("billing_information", user.current_team?.billing_information);
        }
    }, [user]);

    const handleRequest = (form) => patch("/billing/invoices", form);

    const handleSuccess = () => {
        loadUser();

        success(c("teams_billing_information_success"));
    };

    return (
        <Card>
            <CardHeader>{c("teams_billing_information_title")}</CardHeader>

            <form onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}>
                <CardBody>
                    <Content className="mb-4">{c("teams_billing_information_body")}</Content>

                    {alert && (<Alert {...alert} />)}

                    <Textarea
                        label={c("teams_billing_information_field")}
                        name="billing_information"
                        value={value("billing_information")}
                        onChange={handleInput}
                    />
                </CardBody>

                <CardFooter className="flex justify-end">
                    <PrimaryButton working={working}>
                        {c("teams_billing_information_update_button")}
                    </PrimaryButton>
                </CardFooter>
            </form>
        </Card>
    );
};

export default BillingInformation;
