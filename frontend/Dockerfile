FROM node:18

# Set working directory
WORKDIR /app

# Copy files
COPY . .

# Install dependencies
RUN yarn install

# Expose port
EXPOSE 3000

# Default command
CMD ["yarn", "dev"]
