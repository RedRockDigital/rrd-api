import React from "react";
import PropTypes from "prop-types";
import { Modal, ModalHeader, ModalBody, ModalFooter, Input, Select, Alert, PrimaryButton, useForm, useLanguage, useRequest } from "rrd-ui";

import apiKeyExpirationOptions from "@/Config/Options/apiKeyExpirationOptions";

const CreateApiKey = ({ onClose, handleRefresh }) => {
    const {
        form,
        value,
        alert,
        working,
        handleInput,
        handleSubmit,
    } = useForm({
        expiration: "14-days",
    });
    const { c } = useLanguage();
    const { post } = useRequest();

    const handleRequest = () => post("/me/tokens", form);

    const handleSuccess = () => {
        if (handleRefresh) {
            handleRefresh();
        }

        onClose();
    };

    return (
        <Modal>
            <ModalHeader onClose={onClose}>
                {c("api_key_create")}
            </ModalHeader>

            <form onSubmit={(e) => handleSubmit(e, handleRequest, handleSuccess)}>
                <ModalBody className="space-y-4">
                    {alert && (<Alert {...alert} />)}

                    <Input
                        label={c("api_key_name")}
                        value={value("name")}
                        onChange={handleInput}
                        name="name"
                    />

                    <Select
                        label={c("api_key_expiration")}
                        options={apiKeyExpirationOptions}
                        value={value("expiration")}
                        onChange={handleInput}
                        name="expiration"
                    />
                </ModalBody>

                <ModalFooter>
                    <PrimaryButton
                        working={working}
                    >
                        {c("misc_create")}
                    </PrimaryButton>
                </ModalFooter>
            </form>
        </Modal>
    );
};

CreateApiKey.propTypes = {
    onClose: PropTypes.func,
    handleRefresh: PropTypes.func,
};

export default CreateApiKey;
