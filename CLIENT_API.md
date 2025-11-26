# Client Management System - WHMCS Style

Hệ thống quản lý khách hàng tương tự WHMCS với đầy đủ chức năng quản lý thông tin client, invoices, products, domains, quotes, tickets và custom fields.

## Cấu trúc Database

- **clients** - Thông tin khách hàng
- **client_users** - Users liên kết với client
- **invoices** - Hóa đơn
- **products** - Sản phẩm/dịch vụ
- **domains** - Tên miền
- **quotes** - Báo giá
- **tickets** - Support tickets
- **client_custom_fields** - Trường tùy chỉnh

## Web Interface

### Truy cập Client Management

Sau khi đăng nhập, bạn có thể truy cập quản lý clients qua:
- Menu navigation: **Clients**
- URL: `/clients`

### Các chức năng Web Interface

1. **Danh sách Clients** (`/clients`)
   - Hiển thị tất cả clients với pagination
   - Tìm kiếm và lọc clients
   - Xem trạng thái client (Active, Inactive, Closed)
   - Thao tác: View, Edit, Delete

2. **Tạo Client mới** (`/clients/create`)
   - Form nhập đầy đủ thông tin client
   - Validation real-time
   - Các trường: Personal Info, Address, Contact, Options

3. **Chi tiết Client** (`/clients/{id}`)
   - Thông tin đầy đủ về client
   - Thống kê: Invoices, Products, Domains, Tickets
   - Danh sách invoices gần đây
   - Danh sách products/services
   - Danh sách domains
   - Credit balance

4. **Chỉnh sửa Client** (`/clients/{id}/edit`)
   - Form cập nhật thông tin client
   - Tất cả các trường có thể chỉnh sửa
   - Validation và error handling

### Required Fields (Tạo Client)
- **First Name** - Tên
- **Last Name** - Họ
- **Email** - Email (unique)

### Optional Fields
- Company Name, Phone Number
- Address (Address 1, Address 2, City, State, Postcode, Country Code)
- Status (Active, Inactive, Closed)
- Credit Balance
- Marketing Email Opt-in
- Email Verified
- Tax Exempt
- Notes

## API Endpoints (Vẫn khả dụng)

API endpoints vẫn hoạt động song song với web interface tại `/api/v1/clients`
```
GET /api/v1/clients
```

**Response:**
```json
{
  "data": [
    {
      "client_id": 1,
      "uuid": "f08ea4d1-c578-441a-9b0a-aa3aff8b1acf",
      "firstname": "Test",
      "lastname": "Client",
      "fullname": "Test Client",
      "email": "test@example.com",
      "status": "Active",
      ...
    }
  ]
}
```

### 2. Create Client
```
POST /api/v1/clients
```

**Request Body:**
```json
{
  "owner_user_id": 1,
  "firstname": "John",
  "lastname": "Doe",
  "email": "john@example.com",
  "address1": "123 Street",
  "city": "City",
  "state": "State",
  "postcode": "12345",
  "countrycode": "US",
  "phonenumber": "1234567890",
  "status": "Active"
}
```

### 3. Get Client Details with Stats
```
GET /api/v1/clients/{id}
```

**Response:**
```json
{
  "result": "success",
  "client": {
    "client_id": 1,
    "uuid": "...",
    "firstname": "Test",
    "lastname": "Client",
    "fullname": "Test Client",
    "email": "test@example.com",
    "customfields": [...],
    "users": {...}
  },
  "stats": {
    "numdueinvoices": 5,
    "dueinvoicesbalance": 1500.00,
    "numactivedomains": 2,
    "productsnumactive": 3,
    "numtickets": 5,
    "numactivetickets": 2
  }
}
```

### 4. Update Client
```
PUT/PATCH /api/v1/clients/{id}
```

**Request Body:**
```json
{
  "firstname": "Jane",
  "lastname": "Smith",
  "email": "jane.smith@example.com"
}
```

### 5. Delete Client
```
DELETE /api/v1/clients/{id}
```

**Response:**
```json
{
  "result": "success",
  "message": "Client deleted successfully"
}
```

## Validation Rules

### Required Fields (Create)
- `firstname` - Required, string, max 255
- `lastname` - Required, string, max 255
- `email` - Required, unique email

### Optional Fields
- `owner_user_id` - Foreign key to users table
- `companyname` - String, max 255
- `address1`, `address2` - String, max 255
- `city`, `state` - String, max 255
- `postcode` - String, max 20
- `countrycode` - String, exactly 2 characters
- `phonenumber` - String, max 20
- `tax_id` - String, max 50
- `email_preferences` - Array
- `currency_id` - Integer
- `status` - Enum: Active, Inactive, Closed
- `credit` - Decimal
- Boolean flags: `taxexempt`, `marketing_emails_opt_in`, `email_verified`, etc.

## Testing

Chạy tests:
```bash
php artisan test tests/Feature/ClientApiTest.php
```

All tests bao gồm:
- ✓ List clients
- ✓ Create client
- ✓ Show client with stats
- ✓ Update client
- ✓ Delete client
- ✓ Validation errors

## Seeding Data

Chạy seeder để tạo dữ liệu mẫu:
```bash
php artisan db:seed
```

Seeder sẽ tạo:
- 1 admin user (test@example.com / password)
- 10 clients với đầy đủ quan hệ
- Mỗi client có: 2 client users, 5 invoices, 3 products, 2 domains, 2 quotes, 3 tickets, 1 custom field

## Models & Relationships

**Client Model** có các relationships:
- `owner()` - BelongsTo User
- `users()` - HasMany ClientUser
- `invoices()` - HasMany Invoice
- `products()` - HasMany Product
- `domains()` - HasMany Domain
- `quotes()` - HasMany Quote
- `tickets()` - HasMany Ticket
- `customFields()` - HasMany ClientCustomField

**Accessors:**
- `fullname` - Tên đầy đủ (firstname + lastname)
- `isOptedInToMarketingEmails` - Boolean marketing opt-in status

**Methods:**
- `getStats()` - Trả về thống kê đầy đủ về invoices, products, domains, quotes, tickets

## Code Style

Project sử dụng Laravel Pint để format code:
```bash
vendor/bin/pint
```
