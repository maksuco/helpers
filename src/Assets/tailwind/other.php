.avatar {
    @apply size-13 bg-cover bg-center aspect-square <?=$config['btnRadius']?> border border-white;
    @apply flex justify-center items-center font-extrabold text-2xl text-opacity-90;
}

.breadcrumb {
    @apply flex flex-wrap items-center bg-transparent text-xs pr-3 py-2;
  list-style: none;
  .breadcrumb-item {
    @apple pr-1.5;
    &:nth-child(n+2) {
      &:before {
        @apple pr-1.5 inline-block text-gray-200;
        content: "/";
      }
    }
    a {
    @apple font-light text-gray-500;
      &:hover {
        @apple text-primary;
      }
    }
    .active {
        @apple text-primary;
    }
  }
}
