import React from "react";
import { useLocation, useNavigate } from "react-router-dom";
import { Card, CardHeader, CardBody, CardFooter, Input, PrimaryButton, Container, Alert, Link, useAuth, useForm, useLanguage, useRequest, useUser } from "rrd-ui";

import Unauthenticated from "@/Components/Layouts/Unauthenticated";

const Login = () => {
    const { setToken } = useAuth();
    const { loadUser } = useUser();
    const { c } = useLanguage();

    const { handleInput, handleSubmit, value, working, alert, setAlert } = useForm();
    const { post } = useRequest();

    // Record where the user came from so that we can redirect them back after they"ve authed
    const location = useLocation();
    const navigate = useNavigate();
    const from = location.state?.from?.pathname !== "/logout" ? location.state?.from?.pathname : "/";

    /**
     * @function handleRequest
     * @param {object} form
     * @return {Promise<{data, success: boolean, status}|*>}
     */
    const handleRequest = (form) => post("/oauth/token", {
        ...form,
        username: form.email,
        grant_type: "password",
        client_id: import.meta.env.VITE_CLIENT_ID,
        client_secret: import.meta.env.VITE_CLIENT_SECRET,
    });

    /**
     * @function handleSuccess
     * @param {object} response
     */
    const handleSuccess = async (response) => {
        await setToken(response.access_token, response.expires_in, response.refresh_token);

        await loadUser();

        navigate(from);
    };

    /**
     * @function handleError
     */
    const handleError = () => setAlert({
        type: "error",
        message: "Your credentials are invalid",
    });

    return (
        <Unauthenticated>
            <Container sizeClassName="max-w-xl">
                <Card>
                    <form onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess, handleError)}>
                        <CardHeader>{c("login_header")}</CardHeader>

                        <CardBody className="space-y-4">
                            {alert && (<Alert {...alert} />)}

                            <Input
                                label={c("email")}
                                name="email"
                                value={value("email")}
                                onChange={handleInput}
                            />

                            <Input
                                label={c("password")}
                                type="password"
                                name="password"
                                value={value("password")}
                                onChange={handleInput}
                            />
                        </CardBody>

                        <CardFooter className="flex justify-between items-center">
                            <Link to="/password/forgot">
                                {c("forgot_password_link")}
                            </Link>

                            <PrimaryButton working={working}>
                                {c("login_submit")}
                            </PrimaryButton>
                        </CardFooter>
                    </form>
                </Card>

                <p className="text-center text-gray-400 mt-6">
                    {c("login_register_account")} <Link to="/register">{c("login_register_account_link")}</Link>
                </p>
            </Container>
        </Unauthenticated>
    );
};

export default Login;
