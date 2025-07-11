## Database Schema Summary:

### **Core Tables (15 total):**

1. **users** - Main user table (customers, technicians, admins)
2. **customers** - Extended customer information
3. **services** - Available repair services
4. **orders** - Repair orders
5. **inventory_parts** - Parts inventory management
6. **payments** - Payment tracking
7. **order_ratings** - Customer ratings and feedback
8. **service_bookings** - Service booking requests
9. **notifications** - System notifications
10. **technician_schedules** - Technician availability
11. **system_settings** - Application settings
12. **activity_logs** - System activity tracking


### **Pivot/Junction Tables (4 total):**

13. **order_services** - Many-to-many: Orders ↔ Services
14. **order_parts** - Many-to-many: Orders ↔ Inventory Parts
15. **order_status_history** - Order status change tracking
16. **technician_schedules** - Technician time management


### **Key Relationships & Cascade Rules:**

**CASCADE DELETE:**

- `users` → `customers`, `orders`, `payments`, `notifications`, `service_bookings`, `technician_schedules`
- `orders` → `order_services`, `order_parts`, `payments`, `order_ratings`, `order_status_history`
- `services` → `order_services`


**SET NULL:**

- `users` (technicians) → `orders.technician_id`, `order_ratings.technician_id`
- `users` → `order_status_history.user_id`, `activity_logs.user_id`


**RESTRICT:**

- `inventory_parts` → `order_parts` (prevent deletion of parts still in use)


### **Important Indexes:**

- User roles and status
- Order status and priority
- Payment status and due dates
- Customer and technician relationships
- Date-based queries for schedules and history