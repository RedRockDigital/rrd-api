import React from "react";
import PropTypes from "prop-types";
import { Select, useLanguage } from "rrd-ui";

import groupOptions from "@/Config/Options/groupOptions";

const GroupField = ({ name = "group_id", label, value, handleInput }) => {
    const { c } = useLanguage();

    return (
        <Select
            options={groupOptions}
            label={label ?? c("team_users_edit_role")}
            value={value(name)}
            onChange={handleInput}
            name={name}
        />
    );
};

GroupField.propTypes = {
    label: PropTypes.string,
    name: PropTypes.string,
    value: PropTypes.func,
    handleInput: PropTypes.func,
};

export default GroupField;
