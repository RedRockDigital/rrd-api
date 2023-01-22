import React from "react";

import Authenticated from "@/Components/Layouts/Authenticated";
import { PageHeader } from "@/Components/Partials";

const Dashboard = () => {
    return (
        <Authenticated>
            <PageHeader>
                Dashboard
            </PageHeader>
        </Authenticated>
    );
};

export default Dashboard;
