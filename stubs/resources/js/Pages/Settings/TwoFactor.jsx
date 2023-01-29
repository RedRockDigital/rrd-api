import React, { useState, Fragment, useEffect } from "react";
import PropTypes from "prop-types";
import { Alert, PrimaryButton, DangerButton, Card, CardHeader, CardBody, CardFooter, useUser, useRequest, useLanguage } from "rrd-ui";

import SettingsLayout from "@/Components/Layouts/SettingsLayout";

const TwoFactorSettings = () => {
    const [stage, setStage] = useState("welcome");
    const [qrSetup, setQrSetup] = useState({});
    const [working, setWorking] = useState(false);
    const { post, get, del } = useRequest();
    const { user, loadUser } = useUser();
    const { c } = useLanguage();

    useEffect(() => {
        if (user?.two_factor_enabled) {
            setStage("enabled");
        }
    }, [user?.two_factor_enabled]);

    const handleEnable = async () => {
        setWorking(true);

        const enableRequest = await post("/me/two-factor", {});

        if (enableRequest.success) {
            const recoveryCodes = await get("/me/two-factor/recovery-codes");
            const qrCode = await get("/me/two-factor/qr-code");

            if (recoveryCodes.success && qrCode.success) {
                setQrSetup({
                    qrCode: qrCode.data.data.svg,
                    codes: recoveryCodes.data.data.codes,
                });

                await loadUser();

                setStage("enabled");

                setWorking(false);
            }
        }
    };

    const handleDisable = async () => {
        setWorking(true);

        const request = await del("/me/two-factor");

        if (request.success) {
            setStage("welcome");

            setWorking(false);
        }
    };

    return (
        <SettingsLayout>
            <Card>
                <CardHeader>
                    {c("settings_two_factor_title")}
                </CardHeader>

                {stage === "welcome" && (
                    <Welcome
                        handleEnable={handleEnable}
                        working={working}
                    />
                )}

                {stage === "enabled" && (
                    <Enabled
                        {...qrSetup}
                        working={working}
                        handleDisable={handleDisable}
                    />
                )}
            </Card>
        </SettingsLayout>
    );
};

const Welcome = ({ handleEnable, working }) => {
    const { c } = useLanguage();

    return (
        <>
            <CardBody>
                <Alert
                    type="warning"
                    message={c("settings_two_factor_not_enabled")}
                />
            </CardBody>

            <CardFooter className="flex justify-end">
                <PrimaryButton
                    onClick={handleEnable}
                    working={working}
                >
                    {c("settings_two_factor_enable")}
                </PrimaryButton>
            </CardFooter>
        </>
    );
};

Welcome.propTypes = {
    handleEnable: PropTypes.func,
    working: PropTypes.bool,
};

const Enabled = ({ qrCode, codes, working, handleDisable }) => {
    const { c } = useLanguage();

    return (
        <>
            <CardBody className="space-y-3 text-sm text-gray-500">
                <p>
                    {c("settings_two_factor_enabled")}
                </p>

                {qrCode && (
                    <>
                        <p>{c("settings_two_factor_instructions")}</p>

                        <div dangerouslySetInnerHTML={{ __html: qrCode }} />

                        {codes.length > 0 && (
                            <>
                                <p className="my-4 text-md">
                                    {c("settings_two_factor_instructions_recovery_codes")}
                                </p>

                                <pre className="bg-gray-100 p-4">
                                    {codes.map(code => (
                                        <Fragment key={code}>
                                            <span>{code}</span><br />
                                        </Fragment>
                                    ))}
                                </pre>
                            </>
                        )}
                    </>
                )}
            </CardBody>

            <CardFooter>
                <DangerButton onClick={handleDisable} working={working}>
                    {c("settings_two_factor_disabled")}
                </DangerButton>
            </CardFooter>
        </>
    );
};

Enabled.propTypes = {
    qrCode: PropTypes.string,
    codes: PropTypes.array,
    working: PropTypes.bool,
    handleDisable: PropTypes.func,
};

export default TwoFactorSettings;
