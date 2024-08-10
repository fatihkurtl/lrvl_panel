import useAxiosApi from "../utils/axios";

class ApiService {
    public route = '/cart-items';

    public async getCartItems(): Promise<any> {
        try {
            const response = await useAxiosApi.get(this.route);
            return response;
        } catch (error) {
            console.log(error);
        }
    }
}

export default new ApiService();