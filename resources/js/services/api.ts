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

    public async deleteCartItem(id: number): Promise<any> {
        try {
            const response = await useAxiosApi.delete(`/delete${this.route}/${id}`);
            return response;
        } catch (error) {
            console.log(error);
        }
    }

    public async updateCartItem(type: string, id: number): Promise<any> {
        try {
            const response = await useAxiosApi.put(`/update${this.route}/${id}`, {
                type: type,
            });
            return response;
        } catch (error) {
            console.log(error);
        }
    }
}

export default new ApiService();