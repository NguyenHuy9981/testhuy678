## Setup project tại source
- Ta cần nhập api key & secret key của app vào file .env (Xem cách lấy cụ thể ở phần Setup project tại partner).

- Chạy ngrok cùng port với serve sau đó nhập ngrok url vào (APP_URL) tại .env

- Chạy composer install & php artisan serve 

## Setup project tại partner
[Đăng nhập vào partner của shopify](https://www.shopify.com/partners) với tài khoản: vuongsieu9981@gmail.com, mật khẩu: (liên hệ Nguyenhuy129981@gmail.com)

Trong giao diện Shopify Partner, vào Apps->apphuytest->Overview để lấy thông tin api key & secret key.
<h3>Ta cần cấu hình lại đường dẫn: App setup -> nhập ngrok url vào App URL và Allowed redirection URL(s)</h3>

- (https://user-images.githubusercontent.com/95603815/181414435-0ba5ca68-396c-44f3-bbd6-16bece58c0b2.png)



<h2>Store trên shopify</h2>
Trong giao diện Shopify Partner, vào Store->testhuy678->testhuy678.myshopify.com

- (https://user-images.githubusercontent.com/95603815/181416292-b5822b3a-013c-4ff0-a90e-3196cf29e528.png)
- (https://user-images.githubusercontent.com/95603815/181420558-d35cf880-178b-459e-afa7-6b612cb197b1.png)
- (https://user-images.githubusercontent.com/95603815/181417612-b19b2ec2-cb88-4062-845b-fdd50d47b9d7.png)

<h2>App</h2>
Vào App, nhập tên store (store dùng để test: testhuy678)
- (https://user-images.githubusercontent.com/95603815/181418633-b88b6707-9207-4ea2-981d-914d6faaebdc.png)

Sau khi dữ liệu products trên store được lấy về, lúc này Click vào button đồng bộ, mọi hành động thêm,sửa,xóa sản phẩm trên store sẽ được cập nhật dưới App và ngược lại thông qua Webhook.

(https://user-images.githubusercontent.com/95603815/181421848-57fb3f67-6f9c-4892-9f89-1542827ddfd9.png)


