import React from "react";
import { faPlus } from "@fortawesome/free-solid-svg-icons/faPlus";
import { Table as DataTable, useLanguage, useRequest } from "rrd-ui";

import TeamsLayout from "@/Components/Layouts/TeamsLayout";

import { teamUsers } from "@/Config/tables";

import Edit from "./Modals/Edit";
import Create from "./Modals/Create";

const Users = () => {
    const { get } = useRequest();
    const { c } = useLanguage();

    const fetchData = async (page) => get("team/users", { page });

    return (
        <TeamsLayout>
            <DataTable
                actions={[
                    {
                        type: "primary_button",
                        icon: faPlus,
                        modal: "create",
                    },
                ]}
                title={c("teams_users")}
                columns={teamUsers}
                fetchData={fetchData}
                modals={{
                    edit: Edit,
                    create: Create,
                }}
            />
        </TeamsLayout>
    );
};

export default Users;
