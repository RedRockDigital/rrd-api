import React, { useState } from "react";
import { Input, PrimaryButton, Alert, useForm, useRequest, useLanguage } from "rrd-ui";

const Newsletter = () => {
    const [success, setSuccess] = useState(false);

    const { c } = useLanguage();
    const { post } = useRequest();
    const { setAlert, value, working, handleInput, alert, handleSubmit } = useForm();

    const handleRequest = (form) => post("newsletter/subscribe", form);

    const handleSuccess = () => {
        setSuccess(true);

        setAlert({
            type: "success",
            message: c("newsletter_success"),
        });
    };

    return (
        <form
            className="space-y-4 mt-4"
            onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}
        >
            {alert && (
                <Alert {...alert} />
            )}

            {!success && (
                <>
                    <Input
                        label="Email"
                        name="email"
                        placeholder={c("newsletter_email")}
                        value={value("email")}
                        onChange={handleInput}
                    />

                    <div className="flex justify-end">
                        <PrimaryButton working={working}>
                            {c("newsletter_sign_up")}
                        </PrimaryButton>
                    </div>
                </>
            )}
        </form>
    );
};

export default Newsletter;
