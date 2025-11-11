# Release Please Setup Guide for Your GitHub Repository

## Overview
Release Please automates version bumping, CHANGELOG generation, and GitHub Releases using Conventional Commits.
$It fits perfectly with your Git Flow setup: `main` (production) and `develop` (integration).
No deployment to production — only prepares clean, SemVer-compliant releases.

## Prerequisites
1. Use **Conventional Commits**[](https://www.conventionalcommits.org):
   - `feat:` → minor version bump
   - `fix:` → patch version bump
   - `feat!:` or `BREAKING-CHANGE:` → major version bump
   - `chore:`, `docs:`, `refactor:` → no release

2. Use **squash-merge** for all PRs (recommended for linear history).

3. Choose your project type (release-type):

| Type       | Files Modified                     |
|------------|------------------------------------|
| `simple`   | `version.txt`, `CHANGELOG.md`      |
| `node`     | `package.json`, `CHANGELOG.md`     |
| `python`   | `pyproject.toml` or `setup.py`     |
| `java`     | `pom.xml` (SNAPSHOT support)       |
| `rust`     | `Cargo.toml`, `CHANGELOG.md`       |
| `go`       | `CHANGELOG.md`                     |

4. GitHub repository with GitHub Actions enabled.

## Step 1: Create GitHub Secret
1. Go to **Settings > Secrets and variables > Actions**
2. Add new secret:
   - Name: `MY_RELEASE_PLEASE_TOKEN`
   - Value: Personal Access Token with:
     - `repo` (full control)
     - `contents: write`
     - `pull-requests: write`
     - `issues: write`

> Note: Use PAT instead of `GITHUB_TOKEN` to avoid workflow trigger issues.

## Step 2: Create Workflow File
Create `.github/workflows/release-please.yml`:

```yaml
on:
  push:
    branches:
      - main        # Production releases
      # - develop   # Uncomment to test on develop

permissions:
  contents: write
  pull-requests: write
  issues: write

name: release-please

jobs:
  release-please:
    runs-on: ubuntu-latest
    steps:
      - uses: googleapis/release-please-action@v4
        id: release
        with:
          token: ${{ secrets.MY_RELEASE_PLEASE_TOKEN }}
          release-type: simple   # Change to node, python, etc.
          # target-branch: develop  # Optional: test on develop
          # config-file: release-please-config.json
```

## Step 3: Bootstrap Your Repository
1. Make a releasable commit:
   ```bash
   git commit -m "feat: initial setup for release-please"
   ```
2. Push to `main` (or `develop` if testing).
3. Release Please will:
   - Detect changes
   - Create a **Release PR** with updated `CHANGELOG.md` and version
   - Add label: `autorelease: pending`

## Release Process (Git Flow Integration)

### Daily Work
```bash
# Feature branch from develop
git checkout develop
git checkout -b feature/user-login
# Commit with: feat: add login endpoint
# PR → squash-merge into develop
```

### Prepare Release
1. Merge `develop` → `main` (via PR or direct)
2. Push to `main` → triggers Release Please
3. Review auto-generated **Release PR**
4. Merge PR (squash or merge commit)

### After Merge
Release Please automatically:
1. Bumps version in target files
2. Updates `CHANGELOG.md`
3. Tags commit: `v1.2.0`
4. Creates GitHub Release
5. Updates PR label to `autorelease: tagged`

## Advanced: Manual Version Control
Force a specific version:
```bash
git commit --allow-empty -m "chore: release 2.0.0" -m "Release-As: 2.0.0"
```

## Advanced: Override Release Notes
In a merged PR body, add:
```
BEGIN_COMMIT_OVERRIDE
feat: better error handling
fix: memory leak in parser
END_COMMIT_OVERRIDE
```

## Future: Deploy on Tag (Production Ready)
Create `.github/workflows/deploy.yml`:
```yaml
on:
  push:
    tags:
      - 'v*'

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - run: echo "Deploying version ${{ github.ref_name }} to production"
      # Add your deploy steps here (Docker, AWS, etc.)
```

## Configuration File (Optional)
Create `release-please-config.json`:
```json
{
  "packages": {
    ".": {
      "release-type": "simple",
      "changelog-path": "CHANGELOG.md",
      "extra-files": ["version.txt"]
    }
  },
  "bump-minor-pre-id": "beta",
  "bump-patch-for-minor-pre": true
}
```
Then add to workflow:
```yaml
config-file: release-please-config.json
```

## Troubleshooting
| Issue                                 | Fix |
|---------------------------------------|-----|
| No Release PR created                 | Ensure `feat:`/`fix:` commits exist. Remove old `autorelease: pending` labels. |
| Workflow not triggering on PR merge   | Use PAT, not `GITHUB_TOKEN`. |
| Wrong changelog entries               | Use squash-merge + `BEGIN_COMMIT_OVERRIDE`. |
| No tag after merge                    | Check Action logs. Re-run failed job. |

## CLI (Local Testing)
```bash
npm install -g release-please
release-please release-pr \
  --repo-url=your-org/your-repo \
  --token=$GITHUB_TOKEN \
  --release-type=simple
```

## Summary
1. Use Conventional Commits
2. Squash-merge PRs
3. Push to `main` → Release PR
4. Merge PR → Tag + GitHub Release
5. Ready for production deploy on `v*` tags

Your repo is now **SemVer-compliant**, **automated**, and **production-ready**.

---
Generated on: November 11, 2025 11:05 AM CET
Country: Poland (PL)
Tool: https://github.com/googleapis/release-please
---
