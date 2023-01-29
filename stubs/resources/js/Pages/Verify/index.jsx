import React, { useEffect, useState } from "react";
import { useLocation, useParams } from "react-router-dom";
import { Alert, Container, Link, Loading, Card, CardBody, CardFooter, Complete, PrimaryButton, useForm, useUser, useLanguage, useRequest, Input } from "rrd-ui";

import Unauthenticated from "@/Components/Layouts/Unauthenticated";

const Verify = () => {
    const params = useParams();
    const location = useLocation();
    const { get, post } = useRequest();
    const { c } = useLanguage();
    const { user } = useUser();
    const { value, working, alert, handleInput, handleSubmit, setForm } = useForm();

    const [loading, setLoading] = useState(false);
    const [completed, setCompleted] = useState(false);

    const getParams = () => {
        // Fetch the signature value from query strings because laravel won't add it as a "nice" parameter.
        const queryParams = new URLSearchParams(location.search);
        const searchParams = Object.fromEntries(queryParams.entries());

        return {
            ...params,
            ...searchParams,
        };
    };

    const handleRequest = (form = {}) => post("verify-email", {
        ...getParams(),
        ...form,
    });

    const handleSuccess = () => setCompleted(true);

    useEffect(() => {
        (async () => {
            setLoading(true);

            const request = await get("verify-email", getParams());

            if (request.success) {
                if (request.data.data.is_setup) {
                    const submitRequest = await handleRequest();

                    if (submitRequest.success) {
                        handleSuccess();
                    }
                } else {
                    setForm({
                        first_name: request.data.data.first_name,
                        last_name: request.data.data.last_name,
                    });
                }

                setLoading(false);
            }
        })();
    }, []);

    return (
        <Unauthenticated>
            <Container sizeClassName="max-w-xl">
                <Card>
                    {loading && (
                        <CardBody>
                            <Loading />
                        </CardBody>
                    )}

                    {!loading && !completed && (
                        <form onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}>
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
                                    {c("verification_submit")}
                                </PrimaryButton>
                            </CardFooter>
                        </form>
                    )}

                    {!loading && completed && (
                        <Complete
                            title={c("verification_successful")}
                            message={c("verification_successful_message")}
                        />
                    )}
                </Card>

                <p className="text-center text-gray-400 mt-6">
                    {user
                        ? (
                                <>
                                    {c("back_to_account")} <Link to="/dashboard">{c("back_to_account_link")}</Link>
                                </>
                            )
                        : (
                                <>
                                    {c("login_already_got_account")} <Link to="/register">{c("login_already_got_account_link")}</Link>
                                </>
                            )}
                </p>
            </Container>
        </Unauthenticated>
    );
};

export default Verify;
