import React, { useEffect } from "react";
import PropTypes from "prop-types";
import { Modal, ModalHeader, ModalBody, ModalFooter, PrimaryButton, Alert, useForm, useLanguage, useRequest, useToast } from "rrd-ui";

import { GroupField } from "@/Components/Partials/Form";

const Edit = ({ onClose, handleRefresh, routes, item }) => {
    const { c } = useLanguage();
    const { patch } = useRequest();
    const { success } = useToast();
    const { setFieldValue, alert, working, handleInput, handleSubmit, value } = useForm();

    useEffect(() => {
        if (item?.group?.id) {
            setFieldValue("group_id", item.group.id);
        }
    }, [item]);

    const handleRequest = (data) => patch(routes.update, data);

    const handleSuccess = async () => {
        if (handleRefresh) {
            await handleRefresh();
        }

        success(c("team_users_update_success"));

        onClose();
    };

    return (
        <Modal>
            <ModalHeader onClose={onClose}>
                {c("team_users_edit_title")}
            </ModalHeader>

            <form onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}>
                <ModalBody className="space-y-4">
                    {alert && (<Alert {...alert} />)}

                    <GroupField
                        value={value}
                        handleInput={handleInput}
                    />
                </ModalBody>

                <ModalFooter className="flex justify-end">
                    <PrimaryButton working={working}>
                        {c("team_users_edit_update_button")}
                    </PrimaryButton>
                </ModalFooter>
            </form>
        </Modal>
    );
};

Edit.propTypes = {
    onClose: PropTypes.func,
    handleRefresh: PropTypes.func,
    routes: PropTypes.object,
    item: PropTypes.object,
};

export default Edit;
