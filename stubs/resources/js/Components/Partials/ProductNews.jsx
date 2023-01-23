import React, { useState, useEffect } from "react";
import PropTypes from "prop-types";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faStar } from "@fortawesome/free-solid-svg-icons/faStar";
import { ModalTrigger, Modal, ModalHeader, ModalBody, useLanguage } from "rrd-ui";

import version from "@/Config/version";
import changeLog from "@/Config/changeLog";

const ProductNews = () => {
    const [hasNewRelease, setHasNewRelease] = useState(false);

    useEffect(() => {
        const lastViewedVersion = localStorage.getItem("_last_viewed_version");

        setHasNewRelease(!lastViewedVersion || lastViewedVersion !== version);
    }, []);

    return (
        <ModalTrigger
            className={`px-3 py-2 rounded-md text-sm font-medium ${hasNewRelease ? "text-red-400" : "text-gray-200"} hover:text-white cursor-pointer`}
            component={ProductNewsModal}
            onClick={() => setHasNewRelease(false)}
        >
            <FontAwesomeIcon icon={faStar} />
        </ModalTrigger>
    );
};

const ProductNewsModal = ({ onClose }) => {
    const { c } = useLanguage();
    const sections = [
        {
            title: c("product_news_feature"),
            type: "feature",
        },
        {
            title: c("product_news_improvement"),
            type: "improvement",
        },
        {
            title: c("product_news_bugs"),
            type: "bug",
        },
    ];

    useEffect(() => {
        localStorage.setItem("_last_viewed_version", version);
    }, []);

    return (
        <Modal position="right" className="h-screen rounded-r-none">
            <ModalHeader onClose={onClose}>
                {c("product_news_title")}
            </ModalHeader>

            <ModalBody className="divide-y divide-gray-200">
                {sections?.map(section => {
                    const changes = changeLog
                        .filter(change => change.type === section.type);

                    if (changes.length === 0) {
                        return null;
                    }

                    return (
                        <div key={section.type} className="py-4 text-gray-500">
                            <h2 className="text-lg font-medium leading-6 text-gray-700">{section.title}</h2>

                            <ul className="list-disc pl-4">
                                {changes.map((change, key) => (
                                    <li key={key}>
                                        {change.description}
                                    </li>
                                ))}
                            </ul>
                        </div>
                    );
                })}
            </ModalBody>
        </Modal>
    );
};

ProductNewsModal.propTypes = {
    onClose: PropTypes.func,
};

export default ProductNews;
