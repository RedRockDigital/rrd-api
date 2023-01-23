import React from "react";
import PropTypes from "prop-types";
import { Modal, ModalHeader, ModalBody, ModalFooter, PrimaryButton, Input, Alert, useForm, useLanguage, useRequest, useToast } from "rrd-ui";

import { GroupField } from "@/Components/Partials/Form";

const Create = ({ onClose, handleRefresh }) => {
    const { c } = useLanguage();
    const { post } = useRequest();
    const { success } = useToast();
    const { value, working, alert, handleInput, handleSubmit } = useForm();

    const handleRequest = (form) => post("team/users", form);

    const handleSuccess = () => {
        if (handleRefresh) {
            handleRefresh();
        }

        success(c("team_users_create_success"));

        onClose();
    };

    return (
        <Modal>
            <ModalHeader onClose={onClose}>
                {c("team_users_create_title")}
            </ModalHeader>

            <form onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}>
                <ModalBody className="space-y-4">
                    {alert && (<Alert {...alert} />)}

                    <Input
                        value={value("email")}
                        name="email"
                        onChange={handleInput}
                        label={c("team_users_create_email_field")}
                    />

                    <GroupField
                        value={value}
                        handleInput={handleInput}
                    />
                </ModalBody>

                <ModalFooter className="flex justify-end">
                    <PrimaryButton working={working}>
                        {c("team_users_invite_button")}
                    </PrimaryButton>
                </ModalFooter>
            </form>
        </Modal>
    );
};

Create.propTypes = {
    onClose: PropTypes.func,
    handleRefresh: PropTypes.func,
};

export default Create;
