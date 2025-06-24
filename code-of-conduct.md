# Git & GitHub

## Chain of Commits
The chain of commits and merge for this project is as follows:  
`dev-x` → `development` → `master`

## Branches
- **`dev-x`**: Personal developer branch (replace `x` with your identifier)
- **`development`**: Staging branch for integration and testing
- **`master`**: Production-ready, stable code

---

## Git Command Help

1. **Create a local feature/bugfix branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```
2. Merge your local changes to your name branch (dev-x)
3. Make a pull request to development with your new changes
4. Make pull request from development to master
5. Pull current changes to master branch
6. Rebase any branch to master


## Commit Message Guidelines
| Prefix       | When to Use                          | Example                          |
|--------------|--------------------------------------|----------------------------------|
| `[FEATURE]`  | New functionality or major additions | `[FEATURE] Add user dashboard`   |
| `[FIX]`      | Bug fixes and error corrections      | `[FIX] Login form validation`    |
| `[TWEAK]`    | Minor improvements/refactoring       | `[TWEAK] Button hover states`    |
