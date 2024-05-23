# Site Groups

Put your site inventory into groups so that you can assign variables for all sites in the group.

For example: To create runners, you need an API key on the repo. It would be the same across all sites.

If you use group_vars/GROUPNAME.yml, all site in that group will inherit the value.

Use this for secrets:

                # ./ansible/group_vars/project.yml
                # The key works for this repo.
                github_runner_api_token: gh_1110101

That way you can host multiple repos.

