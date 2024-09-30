// ping-response.interface.ts
export interface PingResponse {
    message: string;
    data: {
        timestamp: string;
        status: string;
    };
}
