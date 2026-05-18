export class numberFormatter {
  static calculatePriceWithDecimals(price: number) {
    return price / 100;
  }

  static replaceCommaWithDot(data: string) {
    return Number(data.replace(',', '.'));
  }

  static calculatePriceInInteger(startingPrice: string) {
    const priceWithDot = this.replaceCommaWithDot(startingPrice)
    return priceWithDot * 100;
  }
}
