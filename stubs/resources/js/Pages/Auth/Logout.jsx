import React, { useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Loading, useAuth, useUser } from "rrd-ui";

const Logout = () => {
    const { removeToken } = useAuth();
    const { resetUser } = useUser();
    const navigate = useNavigate();

    useEffect(() => {
        (async () => {
            await removeToken();
            await resetUser();

            navigate("/");
        })();
    }, []);

    return (
        <Loading />
    );
};

export default Logout;
