import React from "react";
import { Table as DataTable, useLanguage, useRequest } from "rrd-ui";

import { invoices } from "@/Config/tables";

const Invoices = () => {
    const { c } = useLanguage();
    const { get } = useRequest();

    const fetchInvoices = () => get("billing/invoices");

    return (
        <DataTable
            noDataMessage={c("teams_billing_invoices_no_data")}
            title={c("teams_billing_invoices_title")}
            columns={invoices}
            fetchData={fetchInvoices}
        />
    );
};

export default Invoices;
