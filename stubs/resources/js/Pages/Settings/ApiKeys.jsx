import React from "react";
import { faPlus } from "@fortawesome/free-solid-svg-icons/faPlus";
import { Table as DataTable, useRequest, useLanguage } from "rrd-ui";

import SettingsLayout from "@/Components/Layouts/SettingsLayout";

import CreateApiKey from "./Modals/CreateApiKey";

import { apiKeys as akiKeysTable } from "@/Config/tables";

const ApiKeys = () => {
    const { c } = useLanguage();
    const { get } = useRequest();

    const fetchKeys = async (page = 1) => await get("/me/tokens", {
        page,
    });

    return (
        <SettingsLayout>
            <DataTable
                title={c("settings_api_keys_header")}
                fetchData={fetchKeys}
                columns={akiKeysTable}
                actions={[
                    {
                        type: "primary_button",
                        icon: faPlus,
                        modal: {
                            component: CreateApiKey,
                        },
                    },
                ]}
            />
        </SettingsLayout>
    );
};

export default ApiKeys;
