/**
 *
 * @param message
 * @returns {Error}
 */
export const invalidResponseException = (message) => throw new Error(message || "Received invalid response");
