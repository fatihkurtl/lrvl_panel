export interface IShoppingCart {
    items: any[];
    total: number;
    quantity: number;
}

export interface IOrderSummary {
    originalPrice: number;
    savings: number;
    storePickups: number;
    tax: number;
    total: number;
}