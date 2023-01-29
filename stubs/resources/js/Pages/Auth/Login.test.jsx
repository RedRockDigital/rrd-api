import React from "react";
import { render } from "@testing-library/react";
import { describe, it, expect } from "vitest";
import { Test } from "rrd-ui";

import Login from "./Login";

import testConfig from "@/tests/testConfig";

window.HTMLElement.prototype.scrollIntoView = function () {};

describe("Login page renders", () => {
    it("renders the header", () => {
        const { container } = render(
            <Test
                config={testConfig}
            >
                <Login />
            </Test>
        );

        expect(container.querySelector("input")).toBeInTheDocument();
        expect(container.querySelector("button")).toBeInTheDocument();
    });
});
